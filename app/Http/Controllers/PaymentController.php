<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Parents;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        
        // Données pour les modals d'édition
        $parents = Parents::with('user')->get();
        $students = Student::with('user')->get();

        return view('backend.payments.index', compact(
            'payments', 
            'stats', 
            'academicYears', 
            'paymentTypes',
            'parents',
            'students'
        ));
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

        // Données pour les modals d'édition
        $parents = Parents::with('user')->get();
        $students = Student::with('user')->get();
        
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
            'status' => 'nullable|in:pending,paid,overdue,cancelled',
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
            'status' => $request->status ?? $payment->status,
            'notes' => $request->notes,
            'updated_by' => auth()->id()
        ]);

        return redirect()->route('payments.index')
                         ->with('success', 'Paiement mis à jour avec succès.');
    }

    // Nouvelle méthode pour marquer comme payé depuis les modals
    public function markPaid(Request $request, Payment $payment)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'transaction_reference' => 'nullable|string'
        ]);

        // Utiliser la méthode existante ou créer une nouvelle logique
        $payment->update([
            'status' => 'paid',
            'payment_method' => $request->payment_method,
            'transaction_reference' => $request->transaction_reference,
            'paid_date' => now(),
            'updated_by' => auth()->id()
        ]);

        return redirect()->back()
                         ->with('success', 'Paiement marqué comme payé avec succès.');
    }

    // Alias pour la compatibilité avec l'ancien code
    public function markAsPaid(Request $request, Payment $payment)
    {
        return $this->markPaid($request, $payment);
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

    //Méthode pour marquer automatiquement les paiements en retard
    public function updateOverduePayments()
    {
        try {
            // Récupérer tous les paiements en attente dont la date d'échéance est dépassée
            $overduePayments = Payment::where('status', 'pending')
                                     ->where('due_date', '<', Carbon::now())
                                     ->get();

            $updated = 0;
            foreach ($overduePayments as $payment) {
                $payment->update([
                    'status' => 'overdue',
                    'updated_by' => auth()->id(),
                    'updated_at' => now()
                ]);
                $updated++;
            }

            // Message de succès avec détails
            if ($updated > 0) {
                return redirect()->route('payments.index')
                               ->with('success', "{$updated} paiement(s) marqué(s) comme en retard.");
            } else {
                return redirect()->route('payments.index')
                               ->with('info', 'Aucun paiement en retard trouvé.');
            }

        } catch (\Exception $e) {
            return redirect()->route('payments.index')
                           ->with('error', 'Erreur lors de la mise à jour des paiements en retard: ' . $e->getMessage());
        }
    }

    // Méthode pour afficher les paiements d'un parent
    public function parentPayments(Request $request)
    {
        // Récupérer le parent connecté
        $parentUser = auth()->user();
        $parent = Parents::where('user_id', $parentUser->id)->first();

        if (!$parent) {
            return redirect()->route('home')->with('error', 'Profil parent non trouvé.');
        }

        $query = Payment::with(['parent.user', 'student.user'])
                       ->where('parent_id', $parent->id);

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
                  ->orWhere('period', 'like', "%{$search}%");
            });
        }

        $payments = $query->latest()->paginate(10);

        // Statistiques pour ce parent
        $stats = [
            'total_payments' => Payment::where('parent_id', $parent->id)->count(),
            'pending_payments' => Payment::where('parent_id', $parent->id)->pending()->count(),
            'paid_payments' => Payment::where('parent_id', $parent->id)->paid()->count(),
            'overdue_payments' => Payment::where('parent_id', $parent->id)->overdue()->count(),
            'total_amount_pending' => Payment::where('parent_id', $parent->id)->pending()->sum('amount'),
            'total_amount_paid' => Payment::where('parent_id', $parent->id)->paid()->sum('amount'),
            'total_amount_overdue' => Payment::where('parent_id', $parent->id)->overdue()->sum('amount'),
        ];

        $academicYears = Payment::where('parent_id', $parent->id)->distinct()->pluck('academic_year');
        $paymentTypes = Payment::where('parent_id', $parent->id)->distinct()->pluck('payment_type');

        return view('backend.payments.parent-index', compact(
            'payments', 
            'stats', 
            'academicYears', 
            'paymentTypes',
            'parent'
        ));
    }
}