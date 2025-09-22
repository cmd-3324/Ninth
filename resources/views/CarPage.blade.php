@extends('layouts.app')
@section('title', 'CarPage')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
.nav-duplicate {
    display: none !important;
}
    #flash-message {
        opacity: 0;
        transition: opacity 0.5s ease;
        position: fixed;
        top: 1rem;
        left: 50%;
        transform: translateX(-50%);
        z-index: 50;
        max-width: 600px;
        width: 90%;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        text-align: center;
        color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    #flash-message.show {
        opacity: 1 !important;
    }
    .car-disabled {
        background-color: #f3f4f6 !important;
        color: #9ca3af !important;
    }
    .car-name-disabled {
        text-decoration: line-through;
    }
    .btn-disabled {
        opacity: 0.6;
        cursor: not-allowed !important;
    }
    .alert {
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.alert-success {
    background-color: #d1fae5;
    color: #065f46;
    border-left: 4px solid #10b981;
}

.alert-error {
    background-color: #fee2e2;
    color: #b91c1c;
    border-left: 4px solid #ef4444;
}

.alert .close-btn {
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
    color: inherit;
}
.like-btn {
    display: flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 20px;
    border: 1px solid #e5e7eb;
    background: white;
    transition: all 0.2s ease;
    cursor: pointer;
    margin-left: 20px;

    /* Move up by 5px and right by 5px */
    transform: translate(5px, -5px);
}


.like-btn:hover {
    background: #f3f4f6;
}

.like-btn.liked {
    background-color: #4f46e5;
    color: white;

    border-color: #4f46e5;
}

.like-btn.liked:hover {
    background-color: #4338ca;
    border-color: #4338ca;
}

.like-btn.not-liked {
    background-color: white;
    color: #6b7280;
}

.like-btn.not-liked:hover {
    background-color: #f9fafb;
    color: #4f46e5;
}

/* Replies Section Styles */
.replies-section {
    margin-top: 15px;
    padding-left: 40px;
    border-left: 2px solid #e5e7eb;
}

.reply-form {
    margin-top: 15px;
    padding: 15px;
    background-color: #f9fafb;
    border-radius: 8px;
}

.reply-card {
    background-color: #f9fafb;
    padding: 12px 15px;
    border-radius: 8px;
    margin-top: 10px;
}

.view-replies-btn {
    background: none;
    border: none;
    color: #4f46e5;
    cursor: pointer;
    font-size: 14px;
    padding: 5px 0;
    margin-top: 10px;
    display: flex;
    align-items: center;
}

.view-replies-btn:hover {
    text-decoration: underline;
}

.view-replies-btn i {
    margin-right: 5px;
    transition: transform 0.3s ease;
}

.view-replies-btn.expanded i {
    transform: rotate(90deg);
}

.replies-container {
    display: none;
}

.replies-container.expanded {
    display: block;
}
</style>

<div class="container mx-auto px-4 py-8">

   @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif

    @if(!empty($searchTerm))
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6">
            <p>Showing results for: <strong>"{{ $searchTerm }}"</strong></p>
            <form action="{{ route('Search_car_page') }}" method="GET" class="inline">
                <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm underline bg-transparent border-none p-0">
                    Clear search and show all cars
                </button>
            </form>
        </div>
    @endif
{{ $cars->links() }}
    <h2 class="text-3xl font-bold mb-6 flex items-center gap-2">
        <i class="fas fa-car text-blue-500"></i> Available Cars
        @if(!empty($searchTerm))
            <span class="text-sm text-gray-500">(Filtered results)</span>
        @endif
    </h2>

    @if($cars->where('available_as', '>', 0)->count() > 0)
        <p class="text-gray-600 mb-4">Existing Cars: {{ $cars->where('available_as', '>', 0)->count() }}</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($cars as $carItem)
                @if($carItem->available_as > 0)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
                        <h3 class="text-xl font-semibold mb-2 flex items-center gap-2">
                            <i class="fas fa-id-card text-gray-500"></i> {{ $carItem->name }} — <span class="text-sm text-gray-400">#{{ $carItem->car_id }}</span>
                        </h3>
                        <p class="text-gray-600 mb-1">
                            <i class="fas fa-chart-line text-purple-500"></i> Sell Number: <strong>{{ $carItem->sell_number }}</strong>
                        </p>
                        <p class="text-gray-600 mb-1">
                            <i class="fas fa-coins text-green-500"></i> Total Benefit: <strong>{{ number_format($carItem->benefit) }}</strong>
                        </p>
                        <p class="text-gray-600 mb-1">
                             <i class="fas fa-coins text-green-500"></i> Favorite Count: <strong>{{ number_format($carItem->fav_num) }}</strong>
                        </p>
                        <p class="text-gray-600 mb-1">
                            <i class="fas fa-users text-teal-500"></i> Total Buyers: <strong>{{ $carItem->total_buyers }}</strong>
                        </p>
                        <p class="text-green-600 font-bold mb-1">
                            <i class="fas fa-dollar-sign"></i> {{ number_format($carItem->price) }}
                        </p>
                        <p class="text-gray-600 mb-4">
                            <i class="fas fa-warehouse text-orange-500"></i> Available: {{ $carItem->available_as }} units
                        </p>

                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('Add-Chart') }}" class="flex-1">
                                @csrf
                                <input type="hidden" name="car_id" value="{{ $carItem->car_id }}">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center justify-center gap-2 transition">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                            </form>

                            <form action="{{ route('Add-To-Fav') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="car_id" value="{{ $carItem->car_id }}">
                                <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded flex items-center justify-center gap-2 transition">
                                    <i class="fas fa-heart"></i> Favorite
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-md p-6 car-disabled">
                        <h3 class="text-xl font-semibold mb-2 flex items-center gap-2 car-name-disabled">
                            <i class="fas fa-id-card text-gray-500"></i> {{ $carItem->name }} — <span class="text-sm text-gray-400">#{{ $carItem->car_id }}</span>
                        </h3>
                        <p class="mb-1">
                            <i class="fas fa-chart-line text-gray-500"></i> Sell Number: <strong>{{ $carItem->sell_number }}</strong>
                        </p>
                        <p class="mb-1">
                            <i class="fas fa-coins text-gray-500"></i> Total Benefit: <strong>{{ number_format($carItem->benefit) }}</strong>
                        </p>
                        <p class="mb-1">
                             <i class="fas fa-coins text-gray-500"></i> Favorite Count: <strong>{{ number_format($carItem->fav_num) }}</strong>
                        </p>
                        <p class="mb-1">
                            <i class="fas fa-users text-gray-500"></i> Total Buyers: <strong>{{ $carItem->total_buyers }}</strong>
                        </p>
                        <p class="font-bold mb-1 text-gray-600">
                            <i class="fas fa-dollar-sign"></i> {{ number_format($carItem->price) }}
                        </p>
                        <p class="mb-4 text-red-500">
                            <i class="fas fa-warehouse"></i> Out of Stock
                        </p>

                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('Add-Chart') }}" class="flex-1">
                                @csrf
                                <input type="hidden" name="car_id" value="{{ $carItem->car_id }}">
                                <button type="submit" class="w-full bg-gray-400 text-white px-4 py-2 rounded flex items-center justify-center gap-2 btn-disabled" disabled>
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                            </form>

                            <form action="{{ route('Add-To-Fav') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="car_id" value="{{ $carItem->car_id }}">
                                <button type="submit" class="w-full bg-gray-400 text-white px-4 py-2 rounded flex items-center justify-center gap-2 btn-disabled" disabled>
                                    <i class="fas fa-heart"></i> Favorite
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="bg-gray-100 rounded-lg p-8 text-center">
            <i class="fas fa-car text-gray-400 text-5xl mb-4"></i>
            <p class="text-gray-500 text-xl">No cars available at the moment.</p>
            @if(!empty($searchTerm))
                <p class="text-gray-600 mt-2">No results found for "{{ $searchTerm }}"</p>
                <a href="{{ route('all-cars') }}" class="text-blue-600 hover:text-blue-800 underline mt-4 inline-block">View all cars</a>
            @endif
        </div>
    @endif

    @if($cars->where('available_as', '>', 0)->where('sell_number', '>=', 5)->count() > 0)
        <h2 class="text-3xl font-bold mt-12 mb-6 flex items-center gap-2">
            <i class="fas fa-fire text-red-500"></i> Most Sold Cars
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($cars as $carItem)
                @if ($carItem->available_as > 0 && $carItem->sell_number >= 5)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 border-2 border-red-100 relative">
                        <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs flex items-center gap-1">
                            <i class="fas fa-fire"></i> Popular
                        </div>
                        <h3 class="text-xl font-semibold mb-2 flex items-center gap-2">
                            <i class="fas fa-id-card text-gray-500"></i> {{ $carItem->name }} — <span class="text-sm text-gray-400">#{{ $carItem->car_id }}</span>
                        </h3>
                        <p class="text-gray-600 mb-1">
                            <i class="fas fa-chart-line text-purple-500"></i> Sell Number: <strong>{{ $carItem->sell_number }}</strong>
                        </p>
                        <p class="text-gray-600 mb-1">
                            <i class="fas fa-coins text-green-500"></i> Total Benefit: <strong>{{ number_format($carItem->benefit) }}</strong>
                        </p>
                        <p class="text-gray-600 mb-1">
                            <i class="fas fa-coins text-green-500"></i> Favorite Count: <strong>{{ number_format($carItem->fav_num) }}</strong>
                        </p>
                        <p class="text-gray-600 mb-1">
                            <i class="fas fa-users text-teal-500"></i> Total Buyers: <strong>{{ $carItem->total_buyers }}</strong>
                        </p>
                        <p class="text-green-600 font-bold mb-1">
                            <i class="fas fa-dollar-sign"></i> {{ number_format($carItem->price) }}
                        </p>
                        <p class="text-gray-600 mb-4">
                            <i class="fas fa-warehouse text-orange-500"></i> Available: {{ $carItem->available_as }} units
                        </p>

                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('Add-Chart') }}" class="flex-1">
                                @csrf
                                <input type="hidden" name="car_id" value="{{ $carItem->car_id }}">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center justify-center gap-2 transition">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                            </form>

                            <form action="{{ route('Add-To-Fav') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="car_id" value="{{ $carItem->car_id }}">
                                <button name="addChatbtn" type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded flex items-center justify-center gap-2 transition">
                                    <i class="fas fa-heart"></i> Favorite
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>

<button id="backToTop" title="Back to Top" style="display:none;position: fixed;bottom: 30px;right: 30px;background-color: #3490dc;color: white;border: none;padding: 12px 16px;border-radius: 50%;font-size: 30px;cursor: pointer;box-shadow: 0 4px 6px rgba(0,0,0,0.2);z-index: 100;">↑</button>

  

</section>

<script>
    // Back to top button functionality
    const backToTopBtn = document.getElementById('backToTop');

    window.onscroll = function() {
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
            backToTopBtn.style.display = "block";
        } else {
            backToTopBtn.style.display = "none";
        }
    };

    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Toggle replies visibility
    document.querySelectorAll('.view-replies-btn').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const repliesContainer = document.getElementById(`replies-${commentId}`);

            // Toggle the expanded class
            this.classList.toggle('expanded');
            repliesContainer.classList.toggle('expanded');

            // Update button text
            const replyCount = this.querySelector('span').textContent.match(/\d+/)[0];
            if (repliesContainer.classList.contains('expanded')) {
                this.querySelector('span').textContent = `Hide replies (${replyCount})`;
            } else {
                this.querySelector('span').textContent = `View replies (${replyCount})`;
            }
        });
    });
 function linkifyText(text) {
        const urlPattern = /(\b(https?:\/\/|www\.)[^\s<]+)/gi;

        return text.replace(urlPattern, function(url) {
            let href = url;
            if (!href.match(/^https?:\/\//)) {
                href = 'http://' + href;
            }
            return `<a href="${href}" target="_blank" rel="noopener noreferrer">${url}</a>`;
        });
    }

    // Run on DOM ready
    document.addEventListener("DOMContentLoaded", function () {
        const commentElements = document.querySelectorAll(".comment-message");

        commentElements.forEach(el => {
            const originalText = el.textContent;
            el.innerHTML = linkifyText(originalText);
        });
    });
    // Auto-hide flash messages after 5 seconds
    setTimeout(() => {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.style.opacity = '0';
            setTimeout(() => flashMessage.remove(), 500);
        }
    }, 5000);
</script>

@endsection
