<?php

declare(strict_types=1);

namespace Yajra\DataTables\Html;

use Illuminate\Support\Fluent;
use Illuminate\Support\Traits\Macroable;
use Yajra\DataTables\Html\Enums\LayoutPosition;

class Layout extends Fluent
{
    use Macroable;

    public static function make(array $options = []): static
    {
        return new static($options);
    }

    public function topStart(string|array|null $options, int $order = 0): static
    {
        return $this->top($options, $order, LayoutPosition::Start);
    }

    public function top(array|string|null $options, ?int $order = null, ?LayoutPosition $position = null): static
    {
        if ($order > 0) {
            $this->attributes["top{$order}{$position?->value}"] = $options;
        } else {
            $this->attributes["top{$position?->value}"] = $options;
        }

        return $this;
    }

    public function topEnd(string|array|null $options, int $order = 0): static
    {
        return $this->top($options, $order, LayoutPosition::End);
    }

    public function topEndView(string $selector, int $order = 0): static
    {
        return $this->topView($selector, $order, LayoutPosition::End);
    }

    public function topView(string $selector, int $order = 0, ?LayoutPosition $position = null): static
    {
        $script = "function() { return $('{$selector}').html(); }";

        return $this->top($script, $order, $position);
    }

    public function bottomStartView(string $selector, int $order = 0): static
    {
        return $this->bottomView($selector, $order, LayoutPosition::Start);
    }

    public function bottomView(string $selector, int $order = 0, ?LayoutPosition $position = null): static
    {
        $script = "function() { return $('{$selector}').html(); }";

        return $this->bottom($script, $order, $position);
    }

    public function bottom(array|string|null $options, ?int $order = null, ?LayoutPosition $position = null): static
    {
        if ($order > 0) {
            $this->attributes["bottom{$order}{$position?->value}"] = $options;
        } else {
            $this->attributes["bottom{$position?->value}"] = $options;
        }

        return $this;
    }

    public function bottomEndView(string $selector, int $order = 0): static
    {
        return $this->bottomView($selector, $order, LayoutPosition::End);
    }

    public function topStartView(string $selector, int $order = 0): static
    {
        return $this->topView($selector, $order, LayoutPosition::Start);
    }

    public function bottomStart(string|array|null $options, int $order = 0): static
    {
        return $this->bottom($options, $order, LayoutPosition::Start);
    }

    public function bottomEnd(string|array|null $options, int $order = 0): static
    {
        return $this->bottom($options, $order, LayoutPosition::End);
    }
}
