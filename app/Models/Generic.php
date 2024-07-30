<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Generic extends Model
{
    use HasFactory;

    public static function select($tableName, $columns = '*', $wheres = [], $likes = [], $orderBy = null, $orderType = 'ASC', $groupBy = null)
    {
        return self::query()
            ->from($tableName)
            ->select($columns)
            ->when(!empty($wheres), function ($query) use ($wheres) {
                foreach ($wheres as [$field , $operator, $value]) {
                    $query->where("$field",  "$operator", "$value");
                }
                return $query;
            })
            ->when(!empty($likes), function ($query) use ($likes) {
                foreach ($likes as $field => $likeValue) {
                    $query->where("$field", 'LIKE', "%{$likeValue}%");
                }
                return $query;
            })
            ->when($orderBy && $orderType, function ($query) use ($orderBy, $orderType) {
                return $query->orderBy("$orderBy", "$orderType");
            })
            ->when($groupBy, function ($query) use ($groupBy) {
                return $query->groupBy($groupBy);
            }
        );
    }

    public static function insert($tableName , $data)
    {
        return DB::table($tableName)->insert($data);
    }

    public static function updatin($table, $id, $data)
    {
        $conditions = [$id['name'] => $id['value']];        
        return DB::table($table)->where($conditions)->update($data);
    }

    public static function deletin($table, $id)
    {
        // $conditions = [$id['name'] => $id['value']]; 
        return DB::table($table)->where($id)->delete(); 
    }

}
