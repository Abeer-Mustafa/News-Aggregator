<div class="col col-lg-4 col-md-4 col-sm-12 mb-4">
    <form action="{{ route('fetch_news') }}" class="news-api-form">
        @csrf
        <input type="hidden" name="service" value="NYTimesService">
        <div class="card">
            <div class="card-header text-center bg-info">
                <h5>The New York Times</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="nytimes_begin_date" class="form-label">From Date</label>
                    <input type="date" class="form-control" id="nytimes_begin_date" name="begin_date">
                </div>
                <div class="mb-3">
                    <label for="nytimes_end_date" class="form-label">To Date</label>
                    <input type="date" class="form-control" id="nytimes_end_date" name="end_date">
                </div>
                
                <div class="mb-3">
                    <label for="nytimes_fq" class="form-label">Category</label>
                    <select class="form-control select2" id="nytimes_fq" name="fq[]" multiple>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <small class="text-muted">
                    Developer accounts have specific API request limits
                </small>
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