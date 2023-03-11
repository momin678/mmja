<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountsDocumentItems extends Model
{
    protected $fillable = ['accounts_document_id', 'filename', 'display_name'];

    public function acc_document(){
        return $this->belongsTo(AccountsDocument::class);
    }
}
