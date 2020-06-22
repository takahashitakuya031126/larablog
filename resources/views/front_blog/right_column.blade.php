<div class="col-md-2 mt-3">
    <div class="card rounded-0">
        <div class="card-body bg-primary">
            <div class="card-title text-light">月別アーカイブ</div>
        </div>
        <div class="card-body">
            <ul class="monthly_archive">
                @forelse($month_list as $value)
                    <li class=" card-text" style="font-size: 14px; margin-right: 4px;">
                        <a href="{{ route('front_index', ['year' => $value->year, 'month' => $value->month]) }}">
                            {{ $value->year_month }}
                        </a>
                    </li>
                @empty
                    <p>記事がありません</p>
                @endforelse
            </ul>
        </div>
    </div>
</div>