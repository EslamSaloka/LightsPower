<?php

namespace App\Http\Controllers\API\Specialties;

// Controllers
use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
// Models
use App\Models\Specialty;
// Support
use App\Support\API;
// Resources
use App\Http\Resources\API\Specialties\SpecialtiesResources;

class SpecialtiesController extends Controller
{
    public function index() {
        return (new API)->isOk(__("عرض مدارات التخصص والإهتمام"))->setData(SpecialtiesResources::collection(Specialty::all()))->build();
    }
}
