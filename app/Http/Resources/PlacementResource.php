<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $key
 * @property mixed $platform
 * @property mixed $total
 * @property mixed $invalid_total
 * @property mixed $invalid_total_percent
 * @property mixed $pixel_stuffing
 * @property mixed $pixel_stuffing_percent
 * @property mixed $viewable
 * @property mixed $viewable_percent
 * @property mixed $non_viewable
 * @property mixed $non_viewable_percent
 * @property mixed $mfa_site_symptoms
 * @property mixed $mfa_site_symptoms_percent
 * @property mixed $other_invalid
 * @property mixed $other_invalid_percent
 */
class PlacementResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'key' => $this->key,
            'platform' => $this->platform,
            'total' => $this->total,
            'invalid_total' => $this->invalid_total,
            'invalid_total_percent' => number_format($this->invalid_total_percent, 1),
            'pixel_stuffing' => $this->pixel_stuffing,
            'pixel_stuffing_percent' => number_format($this->pixel_stuffing_percent, 1),
            'viewable' => $this->viewable,
            'viewable_percent' => number_format($this->viewable_percent, 1),
            'non_viewable' => $this->non_viewable,
            'non_viewable_percent' => number_format($this->non_viewable_percent, 1),
            'mfa_site_symptoms' => $this->mfa_site_symptoms,
            'mfa_site_symptoms_percent' => number_format($this->mfa_site_symptoms_percent, 1),
            'other_invalid' => $this->other_invalid,
            'other_invalid_percent' => number_format($this->other_invalid_percent, 1),
        ];
    }
}
