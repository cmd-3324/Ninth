
@props(['name'=>'','textme'=>''])
<section>

    <div>
        {{-- <x-search-form name="sdfsdfsdfsdfsdfsdfsd" textme = '333333333333'> --}}
        {{-- Using props passed to the component --}}
 <h1 {{ $attributes->merge(['class' => 'heading']) }}>Name: {{ $name }}</h1>

        <h1 {{ $attributes->merge(['class' =>'textme']) }}>TExtme : {{ $textme }}</h1>

        {{-- Custom directive example (if defined) --}}
        {{-- {{ $testmedirective() }} --}}

        <p style="color:yellow;">Ignore here</p>
    </div>
       {{-- </x-search-form> --}}
</section>

{{-- To render any inner content passed to the component --}}
{{ $slot }}
