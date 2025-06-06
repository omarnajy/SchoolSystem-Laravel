<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Parents;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['parent.user', 'student.user']);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('parent.user', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('student.user', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->latest()->paginate(15);

        // Statistiques
        $stats = [
            'total_payments' => Payment::count(),
            'pending_payments' => Payment::pending()->count(),
            'paid_payments' => Payment::paid()->count(),
            'overdue_payments' => Payment::overdue()->count(),
            'total_amount_pending' => Payment::pending()->sum('amount'),
            'total_amount_paid' => Payment::paid()->sum('amount'),
        ];

        $academicYears = Payment::distinct()->pluck('academic_year');
        $paymentTypes = Payment::distinct()->pluck('payment_type');

        return view('backend.payments.index', compact('payments', 'stats', 'academicYears', 'paymentTypes'));
    }

    public function create()
    {
        $parents = Parents::with('user')->get();
        $students = Student::with('user')->get();
        
        return view('backend.payments.create', compact('parents', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_id' => 'required|exists:parents,id',
            'student_id' => 'nullable|exists:students,id',
            'payment_type' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'academic_year' => 'required|string',
            'period' => 'nullable|string',
            'due_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $payment = Payment::create([
            'parent_id' => $request->parent_id,
            'student_id' => $request->student_id,
            'invoice_number' => Payment::generateInvoiceNumber(),
            'payment_type' => $request->payment_type,
            'amount' => $request->amount,
            'academic_year' => $request->academic_year,
            'period' => $request->period,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
            'created_by' => auth()->id()
        ]);

        return redirect()->route('payments.index')
                         ->with('success', 'Paiement créé avec succès. Numéro de facture: ' . $payment->invoice_number);
    }

    public function show(Payment $payment)
    {
        $payment->load(['parent.user', 'student.user', 'createdBy', 'updatedBy']);
        
        return view('backend.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        if ($payment->status === 'paid') {
            return redirect()->back()->with('error', 'Impossible de modifier un paiement déjà effectué.');
        }

        $parents = Parents::with('user')->get();
        $students = Student::with('user')->get();
        
        return view('backend.payments.edit', compact('payment', 'parents', 'students'));
    }

    public function update(Request $request, Payment $payment)
    {
        if ($payment->status === 'paid') {
            return redirect()->back()->with('error', 'Impossible de modifier un paiement déjà effectué.');
        }

        $request->validate([
            'parent_id' => 'required|exists:parents,id',
            'student_id' => 'nullable|exists:students,id',
            'payment_type' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'academic_year' => 'required|string',
            'period' => 'nullable|string',
            'due_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $payment->update([
            'parent_id' => $request->parent_id,
            'student_id' => $request->student_id,
            'payment_type' => $request->payment_type,
            'amount' => $request->amount,
            'academic_year' => $request->academic_year,
            'period' => $request->period,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
            'updated_by' => auth()->id()
        ]);

        return redirect()->route('payments.index')
                         ->with('success', 'Paiement mis à jour avec succès.');
    }

    public function markAsPaid(Request $request, Payment $payment)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'transaction_reference' => 'nullable|string'
        ]);

        $payment->markAsPaid($request->payment_method, $request->transaction_reference);

        return redirect()->back()
                         ->with('success', 'Paiement marqué comme payé.');
    }

    public function destroy(Payment $payment)
    {
        if ($payment->status === 'paid') {
            return redirect()->back()->with('error', 'Impossible de supprimer un paiement déjà effectué.');
        }

        $payment->delete();

        return redirect()->route('payments.index')
                         ->with('success', 'Paiement supprimé avec succès.');
    }

    public function bulkCreate()
    {
        return view('backend.payments.bulk-create');
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'payment_type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'academic_year' => 'required|string',
            'period' => 'nullable|string',
            'due_date' => 'required|date',
            'parent_ids' => 'required|array',
            'parent_ids.*' => 'exists:parents,id'
        ]);

        DB::beginTransaction();
        try {
            $created = 0;
            foreach ($request->parent_ids as $parentId) {
                Payment::create([
                    'parent_id' => $parentId,
                    'invoice_number' => Payment::generateInvoiceNumber(),
                    'payment_type' => $request->payment_type,
                    'amount' => $request->amount,
                    'academic_year' => $request->academic_year,
                    'period' => $request->period,
                    'due_date' => $request->due_date,
                    'created_by' => auth()->id()
                ]);
                $created++;
            }

            DB::commit();
            return redirect()->route('payments.index')
                           ->with('success', "{$created} paiements créés avec succès.");

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->with('error', 'Erreur lors de la création des paiements: ' . $e->getMessage());
        }
    }

    // Méthode pour marquer automatiquement les paiements en retard
    public function updateOverduePayments()
    {
        $updated = Payment::where('status', 'pending')
                         ->where('due_date', '<', now())
                         ->update([
                             'status' => 'overdue',
                             'updated_by' => auth()->id()
                         ]);

        return redirect()->back()
                         ->with('success', "{$updated} paiements marqués comme en retard.");
    }
}
?>