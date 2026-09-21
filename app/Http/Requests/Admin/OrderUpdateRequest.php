<?php

namespace App\Http\Requests\Admin;

use App\Models\Order;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class OrderUpdateRequest extends FormRequest
{
    /**
     * Allowed next statuses per field, keyed by the current status.
     * Completed, cancelled, returned, failed and refunded are terminal.
     *
     * @return array<string, array<string, array<int, string>>>
     */
    public static function transitions(): array
    {
        return [
            'order_status' => [
                'pending' => ['processing', 'cancelled'],
                'processing' => ['completed', 'cancelled'],
                'completed' => [],
                'cancelled' => [],
            ],
            'delivery_status' => [
                'pending' => ['shipped'],
                'shipped' => ['delivered', 'returned'],
                'delivered' => ['returned'],
                'returned' => [],
            ],
            'payment_status' => [
                'pending' => ['paid'],
                'paid' => ['refunded'],
                'failed' => [],
                'refunded' => [],
            ],
        ];
    }

    /**
     * Allowed values for a status field: the current value plus its
     * permitted next values, for building edit-form dropdowns.
     *
     * @return array<int, string>
     */
    public static function allowedValues(string $field, string $current): array
    {
        return array_merge([$current], self::transitions()[$field][$current] ?? []);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_status' => ['required', 'in:pending,processing,completed,cancelled'],
            'delivery_status' => ['required', 'in:pending,shipped,delivered,returned'],
            'payment_status' => ['required', 'in:pending,paid,failed,refunded'],
            'delivery_address' => ['required', 'string'],
            'note' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $inner): void {
            $order = $this->route('order');

            if (! $order instanceof Order) {
                return;
            }

            foreach (array_keys(self::transitions()) as $field) {
                $current = $order->getAttribute($field);
                $next = $this->input($field);

                if ($next !== $current && ! in_array($next, self::allowedValues($field, (string) $current), true)) {
                    $inner->errors()->add(
                        $field,
                        __('Cannot change :field from :current to :next.', [
                            'field' => str_replace('_', ' ', $field),
                            'current' => $current,
                            'next' => $next,
                        ])
                    );
                }
            }

            if (($this->input('order_status') === 'cancelled' || $order->getAttribute('order_status') === 'cancelled')
                && $this->input('delivery_status') !== $order->getAttribute('delivery_status')) {
                $inner->errors()->add('delivery_status', __('Delivery status cannot be changed on a cancelled order.'));
            }
        });
    }
}
