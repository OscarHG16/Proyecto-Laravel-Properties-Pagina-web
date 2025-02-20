<form class="form-search col-md-12" style="margin-top: -100px;" method="GET" action="{{ request()->url() }}">
    <div class="row align-items-end">
        <!-- Listing Types -->
        <div class="col-md-3">
            <label for="list-types">Listing Types</label>
            <div class="select-wrap">
                <span class="icon icon-arrow_drop_down"></span>
                <select name="listing_type" id="list-types" class="form-control d-block rounded-0">
                    <option value="">-- Select Type --</option>
                    @foreach($listingTypes as $type)
                        <option value="{{ $type->id }}" {{ request('listing_type') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Offer Type -->
        <div class="col-md-3">
            <label for="offer-types">Offer Type</label>
            <div class="select-wrap">
                <span class="icon icon-arrow_drop_down"></span>
                <select name="offer_type" id="offer-types" class="form-control d-block rounded-0">
                    <option value="">-- Select Offer --</option>
                    <option value="For Sale" {{ request('offer_type') == 'For Sale' ? 'selected' : '' }}>For Sale</option>
                    <option value="For Rent" {{ request('offer_type') == 'For Rent' ? 'selected' : '' }}>For Rent</option>
                    <option value="For Lease" {{ request('offer_type') == 'For Lease' ? 'selected' : '' }}>For Lease</option>
                </select>
            </div>
        </div>

        <!-- Select City -->
        <div class="col-md-3">
            <label for="select-city">Select City</label>
            <div class="select-wrap">
                <span class="icon icon-arrow_drop_down"></span>
                <select name="city" id="select-city" class="form-control d-block rounded-0">
                    <option value="">-- Select City --</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ request('city') == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="col-md-3">
            <input type="submit" class="btn btn-success text-white btn-block rounded-0" value="Search">
        </div>
    </div>
</form>
