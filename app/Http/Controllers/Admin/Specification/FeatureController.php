<?php

namespace App\Http\Controllers\Admin\Specification;

use App\Http\Controllers\Controller;
use App\Models\Specification;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Toggle feature.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Specification $specification)
    {
        $specification->toggle();

        return to_route('admin.categories.show', $specification->category_id)
            ->with('status', __('specification.updated'));
    }
}
