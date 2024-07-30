<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Generic2 extends Model
{
    use HasFactory;

    public function update($table, $id, $data)
    {
        $conditions = [$id['name'] => $id['value']];        
        return DB::table($table)->where($conditions)->update($data);
    }

    // public function delete($table, $id)
    // {
    //     // $conditions = [$id['name'] => $id['value']]; 
    //     return DB::table($table)->where($id)->delete(); 
    // }
}
