<?php

namespace App\Repositories;

use App\Models\Edm;
use App\Models\EdmFile;
use Takaworx\Brix\Traits\RepositoryTrait;

class EdmFileRepository extends EdmFile
{
    use RepositoryTrait;

    /**
     * DB table to be used for this repo
     *
     * @var string
     */
    protected $table = 'edm_files';

    public function upload()
    {
        try {
            $request  = request();
            $fileName = str_random(32);

            switch ($request->input('id')) {
                case 1:
                    $filePath = $request->file('file')
                        ->storeAs('views/edm/sent', "$fileName.blade.php", 'resource');
                    break;
                case 2:
                    $filePath = $request->file('file')
                        ->storeAs('views/edm/received', "$fileName.blade.php", 'resource');
                    break;
                case 3:
                    $filePath = $request->file('file')
                        ->storeAs('views/edm/checkout', "$fileName.blade.php", 'resource');
                    break;
                case 4:
                    $filePath = $request->file('file')
                        ->storeAs('views/edm/welcome', "$fileName.blade.php", 'resource');
                    break;
                case 5:
                    $filePath = $request->file('file')
                        ->storeAs('views/edm/sentToken', "$fileName.blade.php", 'resource');
                    break;
                case 6:
                    $filePath = $request->file('file')
                        ->storeAs('views/edm/receivedToken', "$fileName.blade.php", 'resource');
                    break;
                case 7:
                    $filePath = $request->file('file')
                        ->storeAs('views/edm/monthlySummary', "$fileName.blade.php", 'resource');
                    break;
            }
        } catch (\Exception $e) {
            return $e;
        }
        

        return $fileName;
    }
}
