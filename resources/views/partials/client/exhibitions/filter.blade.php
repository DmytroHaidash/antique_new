<div class="flex items-center -mx-4">
    <form class="px-4">
        @if (request('city'))
            <input type="hidden" name="city" value="{{ request('city') }}">
        @endif

        <label for="year" hidden>{{ __('pages.exhibitions.year') }}</label>
        <select name="year" id="year" class="form-control form-control--select"
                onchange="this.form.submit()">
            @foreach($years as $year)
                <option value="{{ $year }}"
                        {{ request('year') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endforeach
        </select>
    </form>

    <div class="px-4 flex-grow">
        <hr class="my-0 w-full border-b border-purple-900">
    </div>

    <form class="px-4">
        @if (request('year'))
            <input type="hidden" name="year" value="{{ request('year') }}">
        @endif

        <label for="city" hidden>{{ __('pages.exhibitions.city.label') }}</label>
        <select name="city" id="city" class="form-control form-control--select"
                onchange="this.form.submit()">
            <option value="">{{ __('pages.exhibitions.city.default') }}</option>
            @foreach($cities as $city)
                <option value="{{ $city->id }}"
                        {{ request('city') == $city->id ? 'selected' : '' }}>
                    {{ $city->name }}
                </option>
            @endforeach
        </select>
    </form>
</div>