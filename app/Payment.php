<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payment extends Model
{
    protected $fillable = [
        'parent_id',
        'student_id',
        'amount',
        'due_date',
        'payment_date',
        'status',
        'payment_method',
        'description',
        'payment_type',
        'academic_year',
        'month',
        'notes',
        'reference_number',
        'discount'
    ];

    protected $dates = [
        'due_date',
        'payment_date',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    // Relations
    public function parent()
    {
        return $this->belongsTo(Parents::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Accessors
    public function getNetAmountAttribute()
    {
        return $this->amount - $this->discount;
    }

    public function getIsOverdueAttribute()
    {
        return $this->status === 'pending' && $this->due_date < now();
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-green-100 text-green-800',
            'overdue' => 'bg-red-100 text-red-800',
            'partial' => 'bg-blue-100 text-blue-800'
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getPaymentTypeIconAttribute()
    {
        $icons = [
            'tuition' => 'fa-graduation-cap',
            'transport' => 'fa-bus',
            'lunch' => 'fa-utensils',
            'books' => 'fa-book',
            'uniform' => 'fa-tshirt',
            'activities' => 'fa-running',
            'other' => 'fa-receipt'
        ];

        return $icons[$this->payment_type] ?? 'fa-receipt';
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
        return $query->where('status', 'pending')
                    ->where('due_date', '<', now());
    }

    public function scopeForParent($query, $parentId)
    {
        return $query->where('parent_id', $parentId);
    }

    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeForAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }

    public function scopeForMonth($query, $month)
    {
        return $query->where('month', $month);
    }

    // Methods
    public function markAsPaid($paymentMethod = null, $notes = null)
    {
        $this->update([
            'status' => 'paid',
            'payment_date' => now(),
            'payment_method' => $paymentMethod,
            'notes' => $notes,
            'reference_number' => $this->generateReferenceNumber()
        ]);
    }

    public function markAsPartial($paidAmount, $paymentMethod = null, $notes = null)
    {
        $this->update([
            'status' => 'partial',
            'payment_date' => now(),
            'payment_method' => $paymentMethod,
            'notes' => $notes,
            'discount' => $this->amount - $paidAmount,
            'reference_number' => $this->generateReferenceNumber()
        ]);
    }

    public function generateReferenceNumber()
    {
        return 'PAY-' . date('Y') . '-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    // Static methods
    public static function getTotalPendingForParent($parentId)
    {
        return self::where('parent_id', $parentId)
                  ->where('status', 'pending')
                  ->sum('amount');
    }

    public static function getTotalPaidForParent($parentId, $year = null)
    {
        $query = self::where('parent_id', $parentId)
                    ->where('status', 'paid');
        
        if ($year) {
            $query->where('academic_year', $year);
        }

        return $query->sum('amount');
    }

    public static function getPaymentTypes()
    {
        return [
            'tuition' => 'Frais de scolarité',
            'transport' => 'Transport scolaire',
            'lunch' => 'Cantine',
            'books' => 'Manuels scolaires',
            'uniform' => 'Uniforme',
            'activities' => 'Activités extra-scolaires',
            'other' => 'Autres frais'
        ];
    }

    public static function getPaymentMethods()
    {
        return [
            'cash' => 'Espèces',
            'card' => 'Carte bancaire',
            'transfer' => 'Virement bancaire',
            'check' => 'Chèque',
            'online' => 'Paiement en ligne'
        ];
    }

    public static function getCurrentAcademicYear()
    {
        $currentMonth = date('n');
        $currentYear = date('Y');
        
        // L'année scolaire commence en septembre
        if ($currentMonth >= 9) {
            return $currentYear . '-' . ($currentYear + 1);
        } else {
            return ($currentYear - 1) . '-' . $currentYear;
        }
    }
}