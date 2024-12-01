<div class="col col-lg-4 col-md-4 col-sm-12 mb-4">
    <form action="{{ route('fetch_news') }}" class="news-api-form">
        @csrf
        <input type="hidden" name="service" value="NewsOrgService">
        <div class="card">
            <div class="card-header text-center bg-info">
                <h5>News API ORG</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="news_org_from" class="form-label">From Date</label>
                    <input type="date" class="form-control" id="news_org_from" name="from">
                </div>
                <div class="mb-3">
                    <label for="news_org_to" class="form-label">To Date</label>
                    <input type="date" class="form-control" id="news_org_to" name="to">
                </div>
                <div class="mb-3">
                    <label for="news_org_sources" class="form-label">Source</label>
                    <select class="form-control select2" id="news_org_sources" name="sources">
                        @foreach ($sources as $key => $source)
                            <option value="{{ $key }}">{{ $source['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <small class="text-muted">
                    Developer accounts are limited to a maximum of 100 results
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