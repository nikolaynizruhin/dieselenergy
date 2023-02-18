<?php

namespace App\Http\Controllers\Admin\Specification;

use App\Http\Controllers\Controller;
use App\Models\Specification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Toggle feature.
     */
    public function update(Request $request, Specification $specification): RedirectResponse
    {
        $specification->toggle();

        return to_route('admin.categories.show', $specification->category_id)
            ->with('status', __('specification.updated'));
    }
}
