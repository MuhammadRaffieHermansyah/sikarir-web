@php
    $appLogoMarkup = trim(view('components.app-logo', [
        'attributes' => new \Illuminate\View\ComponentAttributeBag(),
    ])->render());

    $appLogoDataUri = 'data:image/svg+xml;base64,' . base64_encode($appLogoMarkup);
@endphp

<link rel="icon" type="image/svg+xml" href="{{ $appLogoDataUri }}">
<link rel="apple-touch-icon" href="{{ $appLogoDataUri }}">