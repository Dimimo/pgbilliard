<div>
    <div class="row mr-1 mt-n5 mb-4">
        <div class="col-auto ml-auto">
            <label for="cycle_list"></label>
            <select class="form-control mt-n4" id="cycle_list" title="Change the season">
                @if($cycles)
                    @foreach ($cycles as $c)
                        <option value="/seasons/{{ $c }}"
                                @if ($c == $cycle) selected @endif>{{ $c }}</option>
                    @endforeach
                    @if ($c > $cycle)
                        <option value="/seasons/{{ $c }}" selected>{{ $cycle }}</option>
                    @endif
                    <option value="/seasons/0000/00">All Seasons</option>
                @else
                    <option>No seasons are available in the new database</option>
                @endif
            </select>
        </div>
    </div>
</div>
