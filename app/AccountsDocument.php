<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountsDocument extends Model
{
    public function document_items(){
        return $this->hasMany(AccountsDocumentItems::class);
    }
}
