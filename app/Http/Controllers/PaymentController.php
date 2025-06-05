<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Parents;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($user->hasRole('Admin')) {
            $query = Payment::with(['parent.user', 'student.user']);
            
            // Filtres pour admin
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }
            
            if ($request->has('payment_type') && $request->payment_type != '') {
                $query->where('payment_type', $request->payment_type);
            }
            
            if ($request->has('academic_year') && $request->academic_year != '') {
                $query->where('academic_year', $request->academic_year);
            }
            
            $payments = $query->latest()->paginate(15);
            
            // Statistiques pour admin
            $stats = [
                'total_pending' => Payment::where('status', 'pending')->sum('amount'),
                'total_paid' => Payment::where('status', 'paid')->sum('amount'),
                'total_overdue' => Payment::overdue()->sum('amount'),
                'count_overdue' => Payment::overdue()->count(),
            ];
            
        } elseif ($user->hasRole('Parent')) {
            $parent = $user->parent;
            $payments = Payment::with(['student.user'])
                              ->where('parent_id', $parent->id)
                              ->latest()
                              ->paginate(10);
            
            // Statistiques pour parent
            $stats = [
                'total_pending' => Payment::getTotalPendingForParent($parent->id),
                'total_paid' => Payment::getTotalPaidForParent($parent->id, Payment::getCurrentAcademicYear()),
                'count_overdue' => Payment::where('parent_id', $parent->id)->overdue()->count(),
            ];
        }
        
        return view('backend.payments.index', compact('payments', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Parents::with('user')->latest()->get();
        $students = Student::with(['user', 'class'])->latest()->get();
        $paymentTypes = Payment::getPaymentTypes();
        $academicYear = Payment::getCurrentAcademicYear();
        
        return view('backend.payments.create', compact('parents', 'students', 'paymentTypes', 'academicYear'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'parent_id' => 'required|exists:parents,id',
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'description' => 'required|string|max:255',
            'payment_type' => 'required|in:tuition,transport,lunch,books,uniform,activities,other',
            'academic_year' => 'required|string',
            'month' => 'required|string',
            'discount' => 'nullable|numeric|min:0'
        ]);

        // Vérifier que l'étudiant appartient bien au parent
        $student = Student::findOrFail($request->student_id);
        if ($student->parent_id != $request->parent_id) {
            return back()->withErrors(['student_id' => 'Cet étudiant ne correspond pas au parent sélectionné.']);
        }

        Payment::create([
            'parent_id' => $request->parent_id,
            'student_id' => $request->student_id,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'description' => $request->description,
            'payment_type' => $request->payment_type,
            'academic_year' => $request->academic_year,
            'month' => $request->month,
            'discount' => $request->discount ?? 0,
            'status' => 'pending'
        ]);

        return redirect()->route('payments.index')->with('success', 'Paiement créé avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        $payment->load(['parent.user', 'student.user', 'student.class']);
        
        return view('backend.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        $parents = Parents::with('user')->latest()->get();
        $students = Student::with(['user', 'class'])->latest()->get();
        $paymentTypes = Payment::getPaymentTypes();
        $paymentMethods = Payment::getPaymentMethods();
        
        return view('backend.payments.edit', compact('payment', 'parents', 'students', 'paymentTypes', 'paymentMethods'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'parent_id' => 'required|exists:parents,id',
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'description' => 'required|string|max:255',
            'payment_type' => 'required|in:tuition,transport,lunch,books,uniform,activities,other',
            'academic_year' => 'required|string',
            'month' => 'required|string',
            'discount' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,paid,overdue,partial',
            'payment_method' => 'nullable|in:cash,card,transfer,check,online',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        // Vérifier que l'étudiant appartient bien au parent
        $student = Student::findOrFail($request->student_id);
        if ($student->parent_id != $request->parent_id) {
            return back()->withErrors(['student_id' => 'Cet étudiant ne correspond pas au parent sélectionné.']);
        }

        $updateData = [
            'parent_id' => $request->parent_id,
            'student_id' => $request->student_id,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'description' => $request->description,
            'payment_type' => $request->payment_type,
            'academic_year' => $request->academic_year,
            'month' => $request->month,
            'discount' => $request->discount ?? 0,
            'status' => $request->status,
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
            'notes' => $request->notes
        ];

        // Générer numéro de référence si marqué comme payé
        if ($request->status === 'paid' && !$payment->reference_number) {
            $updateData['reference_number'] = 'PAY-' . date('Y') . '-' . str_pad($payment->id, 6, '0', STR_PAD_LEFT);
        }

        $payment->update($updateData);

        return redirect()->route('payments.index')->with('success', 'Paiement mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        
        return back()->with('success', 'Paiement supprimé avec succès.');
    }

    /**
     * Mark payment as paid
     */
    public function markAsPaid(Request $request, Payment $payment)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,card,transfer,check,online',
            'notes' => 'nullable|string'
        ]);

        $payment->markAsPaid($request->payment_method, $request->notes);

        return back()->with('success', 'Paiement marqué comme payé.');
    }

    /**
     * Generate payment report
     */
    public function report(Request $request)
    {
        $query = Payment::with(['parent.user', 'student.user']);
        
        // Filtres
        if ($request->has('start_date') && $request->start_date) {
            $query->where('payment_date', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $query->where('payment_date', '<=', $request->end_date);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('payment_type') && $request->payment_type) {
            $query->where('payment_type', $request->payment_type);
        }

        $payments = $query->get();
        
        $summary = [
            'total_amount' => $payments->sum('amount'),
            'total_paid' => $payments->where('status', 'paid')->sum('amount'),
            'total_pending' => $payments->where('status', 'pending')->sum('amount'),
            'total_overdue' => $payments->where('status', 'overdue')->sum('amount'),
            'count_payments' => $payments->count(),
            'count_paid' => $payments->where('status', 'paid')->count(),
            'count_pending' => $payments->where('status', 'pending')->count(),
            'count_overdue' => $payments->where('status', 'overdue')->count(),
        ];

        return view('backend.payments.report', compact('payments', 'summary'));
    }

    /**
     * Bulk create payments for all students
     */
    public function bulkCreate(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'description' => 'required|string|max:255',
            'payment_type' => 'required|in:tuition,transport,lunch,books,uniform,activities,other',
            'academic_year' => 'required|string',
            'month' => 'required|string',
            'class_ids' => 'nullable|array',
            'class_ids.*' => 'exists:grades,id'
        ]);

        $studentsQuery = Student::with('parent');
        
        if ($request->has('class_ids') && !empty($request->class_ids)) {
            $studentsQuery->whereIn('class_id', $request->class_ids);
        }
        
        $students = $studentsQuery->get();
        $createdCount = 0;

        foreach ($students as $student) {
            if ($student->parent) {
                Payment::create([
                    'parent_id' => $student->parent_id,
                    'student_id' => $student->id,
                    'amount' => $request->amount,
                    'due_date' => $request->due_date,
                    'description' => $request->description,
                    'payment_type' => $request->payment_type,
                    'academic_year' => $request->academic_year,
                    'month' => $request->month,
                    'status' => 'pending'
                ]);
                $createdCount++;
            }
        }

        return back()->with('success', "{$createdCount} paiements créés avec succès.");
    }

    /**
     * Get students for parent (AJAX)
     */
    public function getStudentsForParent($parentId)
    {
        $students = Student::with(['user', 'class'])
                          ->where('parent_id', $parentId)
                          ->get();
        
        return response()->json($students);
    }
}