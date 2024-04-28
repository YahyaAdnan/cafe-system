<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'amount',
        'user_id',
        'expense_category_id',
        'payment_method_id',
        'note',
    ];

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($model) 
        {
            $model->user_id = Auth::id();
            $model->title = ExpenseCategory::find($model->expense_category_id)->title . ' ' . date('Y/m/d H:i');
        });

        static::created(function ($model) {
            $transaction =  Transaction::create([
                'amount' => - $model->amount,
                'user_id' => $model->user_id,
                'payment_method_id' => $model->payment_method_id,
                'transactionable_type' => 'App\Models\Expense',
                'transactionable_id' => $model->id,
            ]);
        });
    }

    protected $table = 'expenses';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function inventoryRecords()
    {
        return $this->hasMany(InventoryRecord::class);
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

}
