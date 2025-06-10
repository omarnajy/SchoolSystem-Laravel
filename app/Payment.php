<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payment extends Model
{
    protected $fillable = [
        'parent_id',
        'student_id', 
        'invoice_number',
        'payment_type',
        'amount',
        'academic_year',
        'period',
        'status',
        'due_date',
        'paid_date',
        'payment_method',
        'transaction_reference',
        'notes',
        'created_by',
        'updated_by'
    ];

    protected $dates = [
        'due_date',
        'paid_date',
        'created_at',
        'updated_at'
    ];

    // Relations
    public function parent()
    {
        return $this->belongsTo(Parents::class, 'parent_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Accesseurs
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2) . ' DH';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge bg-warning text-dark">En attente</span>',
            'paid' => '<span class="badge bg-success">Payé</span>',
            'overdue' => '<span class="badge bg-danger">En retard</span>',
            'cancelled' => '<span class="badge bg-secondary">Annulé</span>'
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Inconnu</span>';
    }

    public function getDaysOverdueAttribute()
    {
        if ($this->status !== 'overdue' && $this->status !== 'pending') {
            return 0;
        }

        return max(0, Carbon::now()->diffInDays($this->due_date, false));
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue')
                     ->orWhere(function($q) {
                         $q->where('status', 'pending')
                           ->where('due_date', '<', now());
                     });
    }

    public function scopeForAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }

    // Méthodes
    public function markAsPaid($paymentMethod = null, $transactionRef = null)
    {
        $this->update([
            'status' => 'paid',
            'paid_date' => now(),
            'payment_method' => $paymentMethod,
            'transaction_reference' => $transactionRef,
            'updated_by' => auth()->id()
        ]);
    }

    public function markAsOverdue()
    {
        if ($this->status === 'pending' && $this->due_date < now()) {
            $this->update([
                'status' => 'overdue',
                'updated_by' => auth()->id()
            ]);
        }
    }

    public static function generateInvoiceNumber()
    {
        $year = date('Y');
        $lastPayment = static::whereYear('created_at', $year)
                           ->orderBy('id', 'desc')
                           ->first();
        
        $number = $lastPayment ? ((int) substr($lastPayment->invoice_number, -4)) + 1 : 1;
        
        return 'INV-' . $year . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

     // Méthodes pour les statistiques
    public static function getTotalAmountByStatus($parentId = null, $status = 'paid')
    {
        $query = self::where('status', $status);
        
        if ($parentId) {
            $query->where('parent_id', $parentId);
        }
        
        return $query->sum('amount');
    }

    public static function getCountByStatus($parentId = null, $status = 'paid')
    {
        $query = self::where('status', $status);
        
        if ($parentId) {
            $query->where('parent_id', $parentId);
        }
        
        return $query->count();
    }

    // Méthode pour obtenir les paiements d'un parent avec filtres
    public static function getParentPayments($parentId, $filters = [])
    {
        $query = self::with(['student.user'])
                    ->where('parent_id', $parentId);

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['academic_year']) && $filters['academic_year']) {
            $query->where('academic_year', $filters['academic_year']);
        }

        if (isset($filters['payment_type']) && $filters['payment_type']) {
            $query->where('payment_type', $filters['payment_type']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhere('period', 'like', "%{$search}%");
            });
        }

        return $query->latest();
    }
}