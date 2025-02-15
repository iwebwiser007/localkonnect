@php
    use Botble\Base\Enums\SystemUpdaterStepEnum;

    $changelog = isset($latestUpdate) && $latestUpdate && $latestUpdate->changelog ? trim(str_replace(PHP_EOL . PHP_EOL, PHP_EOL, strip_tags(str_replace(['<li>', '</li>', '<ul>'], ['<li>- ', '</li>' . PHP_EOL, PHP_EOL . '<ul>'], $latestUpdate->changelog)))) : ''
@endphp

@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
   <x-core::alert type="info" class="mb-3">
    This system is up-to-date as per the latest standards from <strong>WisenAlpha</strong>.
</x-core::alert>

@endsection
