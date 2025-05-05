<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('dashboard');}}">Dashboard</a> /</span> Journal
    </h6>
    <div class="col-sm-12 col-md-12 col-lg-12 mb-4 mt-3">
        <form wire:submit.prevent="generate">
            <div class="input-group">
                <button class="btn btn-outline-primary">
                    <span class="tf-icons bx bx-calendar"></span>&nbsp; From
                </button>
                <input class="form-control" type="date" wire:model="startDate">
                @error('startDate') <span class="text-danger">{{ $message }}</span> @enderror
                <button class="btn btn-outline-primary">
                    <span class="tf-icons bx bx-calendar"></span>&nbsp; To
                </button>
                <input class="form-control" type="date" wire:model="endDate">
                @error('endDate') <span class="text-danger">{{ $message }}</span> @enderror
                <button type="submit" class="btn btn-outline-primary">
                    <span class="tf-icons bx bx-export"></span>&nbsp; Generate
                </button>
            </div>
        </form>
    </div><hr>
    <div class="card">
        <div class="card-header text-end">
            <!-- Search Field -->
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search Date..."
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-300"
            />
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="fw-bolder">Prepared Date</th>
                            <th class="fw-bolder">Time Frame</th>
                            <th class="fw-bolder">Prepared By</th>
                            <th class="fw-bolder">Authorized By</th>
                            <th class="fw-bolder">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($journals as $journal)
                        <tr>
                            <td>{{ $journal->prepared_date }}</td>
                            <td>{{ $journal->start_date }} >>> {{ $journal->end_date }}</td>
                            <td>{{ $journal->preparedBy->name }}</td>
                            <td>{{ $journal->authorizedBy->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ url('single-journal', $journal->id) }}"><i class="bx bx-show"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $journals->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
