<?php

namespace App\Models;

use App\Models\StudentSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    public function getStatus()
    {
        if($this->status == 1){
            return 'Active';
        }else if($this->status == 2){
            return 'Suspended';
        }else{
            return 'Inactive';
        };
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function subjects(){
        return $this->hasMany(StudentSubject::class);
    }

    public function totalPayments()
    {
        // $total = $this->payments()->sum('amount');
        // return $total > 0 ? "Rs." . number_format($total, 2) : "-";

        if($this->payments()->count()){
            return "Rs " . number_format($this->payments()->sum('amount'), 2) ;
        }

        return "-";
    }
}
