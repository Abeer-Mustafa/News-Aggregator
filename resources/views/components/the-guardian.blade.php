<div class="col col-lg-4 col-md-4 col-sm-12 mb-4">
    <form action="{{ route('fetch_news') }}" class="news-api-form">
        @csrf
        <input type="hidden" name="service" value="TheGuardianService">
        <div class="card">
            <div class="card-header text-center bg-info">
                <h5>The Guardian</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="theguardian_from_date" class="form-label">From Date</label>
                    <input type="date" class="form-control" id="theguardian_from_date" name="from_date">
                </div>
                <div class="mb-3">
                    <label for="theguardian_to_date" class="form-label">To Date</label>
                    <input type="date" class="form-control" id="theguardian_to_date" name="to_date">
                </div>
                <div class="mb-3">
                    <label for="theguardian_section" class="form-label">Category</label>
                    <select class="form-control select2" id="theguardian_section" name="section">
                        @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="text-center card-footer bg-info d-flex flex-column justify-content-center align-items-center">
                <button type="submit" class="btn btn-outline-info news-api-submit">Fetch News</button>
                <div class="spinner spinner-border text-info" role="status" style="display: none">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </form>
</div>