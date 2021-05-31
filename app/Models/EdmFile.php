<?php

namespace App\Models;

use App\Traits\PagerTrait;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Model;

class EdmFile extends Model
{
    use PagerTrait, EloquentJoin;
    
    protected $table = 'edm_files';

    protected $fillable = [
        'edm_id',
        'file',
        'is_active',
    ];

    protected $with = [
        'edm'
    ];

    /**
     * Foreign properties
     **/
    protected $foreignProperties = [
        'edm_name' => 'edm|edm.name',
    ];

    public function edm()
    {
        return $this->belongsTo(Edm::class, 'edm_id');
    }

    public function getBladePathAttribute()
    {
        switch ($this->attributes['edm_id']) {
            case 1:
                $result = "edm.sent.{$this->attributes['file']}";
                break;
            case 2:
                $result = "edm.received.{$this->attributes['file']}";
                break;
            case 3:
                $result = "edm.checkout.{$this->attributes['file']}";
                break;
            case 4:
                $result = "edm.welcome.{$this->attributes['file']}";
                break;
            case 5:
                $result = "edm.sentToken.{$this->attributes['file']}";
                break;
            case 6:
                $result = "edm.receivedToken.{$this->attributes['file']}";
                break;
            case 7:
                $result = "edm.monthlySummary.{$this->attributes['file']}";
                break;
        }

        return $result;
    }
}
