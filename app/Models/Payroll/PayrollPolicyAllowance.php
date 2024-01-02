<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PayrollPolicyAllowance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payroll_policy_id',
        'allowance_id',
    ];

    /**
     * Get the payroll policy associated with the payroll policy allowance.
     */
    public function payrollPolicy()
    {
        return $this->belongsTo(PayrollPolicy::class, 'payroll_policy_id');
    }

    /**
     * Get the allowance associated with the payroll policy allowance.
     */
    public function allowance()
    {
        return $this->belongsTo(Allowance::class, 'allowance_id');
    }

    /**
     * Get the user who created the payroll policy.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated the payroll policy.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * The booting method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payrollPolicyAllowance) {
            if (Auth::check()) {
                $payrollPolicyAllowance->created_by = Auth::id();
            }
        });

        static::updating(function ($payrollPolicyAllowance) {
            if (Auth::check()) {
                $payrollPolicyAllowance->updated_by = Auth::id();
            }
        });
    }
}
