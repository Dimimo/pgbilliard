@if (auth()->check() && auth()->user()->isSuperAdmin())
    <h1>Testing</h1>
@else
    <h1>Booga booga!</h1>
@endif
