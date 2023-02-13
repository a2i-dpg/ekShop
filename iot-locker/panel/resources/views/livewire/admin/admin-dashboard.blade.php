<div>
    {{-- Success is as dangerous as failure. --}}
    <livewire:livewire-column-chart
    key="{{ $columnChartModel->reactiveKey() }}"
    :column-chart-model="$columnChartModel"
    />

    <livewire:livewire-column-chart :column-chart-model="$columnChartModel"
    />
</div>
