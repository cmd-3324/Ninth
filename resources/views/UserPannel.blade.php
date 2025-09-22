
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
        }
        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            transition: width 0.3s;
            z-index: 1000;
        }
        .sidebar a {
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            display: block;
            font-size: 18px;
            border-bottom: 1px solid #444;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #007bff;
            color: white;
        }
        .sidebar .active {
            background-color: #007bff;
            color: white;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .logout-btn {
            margin-top: 20px;
            background: linear-gradient(135deg, #ff4b2b, #ff416c);
            color: white;
            padding: 12px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: center;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
        }
        .content-section {
            display: none;
        }
        .content-section.active {
            display: block;
        }
        .car-table th,
        .car-table td {
            text-align: center;
            padding: 12px;
            border: 1px solid #ddd;
        }
        .car-table th {
            background-color: #007bff;
            color: white;
        }
        .car-table tr:hover {
            background-color: #f1f1f1;
        }
        .action-btn {
            margin: 5px;
            padding: 5px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .delete-btn {
            background-color: #ff4b2b;
            color: white;
        }
        .delete-btn:hover {
            background-color: #ff416c;
        }
        .details-btn {
            background-color: #007bff;
            color: white;
        }
        .details-btn:hover {
            background-color: #0056b3;
        }
        .sort-search-container {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .select-input,
        .search-input {
            margin-right: 10px;
        }
        .profile-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: bold;
            margin-right: 20px;
        }
        .profile-info h2 {
            margin: 0;
            color: #343a40;
        }
        .profile-info p {
            margin: 5px 0;
            color: #6c757d;
        }
        .profile-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .profile-menu-item {
            border-bottom: 1px solid #e9ecef;
        }
        .profile-menu-item:last-child {
            border-bottom: none;
        }
        .profile-menu-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            color: #495057;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .profile-menu-link:hover {
            background-color: #f8f9fa;
            color: #007bff;
        }
        .profile-menu-link i {
            color: #6c757d;
        }
        .danger-zone {
            border-top: 2px solid #ff4b2b;
            padding-top: 20px;
            margin-top: 30px;
        }
        .danger-zone h3 {
            color: #ff4b2b;
            margin-bottom: 15px;
        }
        .danger-btn {
            background-color: #ff4b2b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .danger-btn:hover {
            background-color: #ff416c;
        }
        .profile-subsection {
            margin-top: 20px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .profile-subsection h3 {
            margin-top: 0;
            color: #343a40;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .form-actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            outline: 0;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            position: relative;
            margin: 10% auto;
            width: 400px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        .modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid #e9ecef;
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .modal-body {
            padding: 20px;
        }
        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .close {
            color: white;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
        }
        .close:hover {
            color: #ccc;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .content {
                margin-left: 200px;
            }
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            .profile-avatar {
                margin-right: 0;
                margin-bottom: 15px;
            }
            .sort-search-container {
                flex-direction: column;
                align-items: flex-start;
            }
        }
        img {
            width:20px;
            height:20px;
        }
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 5px;
            color: white;
            z-index: 1100;
            display: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .notification.success {
            background-color: #28a745;
        }
        .notification.error {
            background-color: #dc3545;
        }
        .car-details-modal .modal-content {
            width: 600px;
            max-width: 90%;
        }
        .car-details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            extreme-bottom: 20px;
        }
        .car-detail-item {
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .car-detail-label {
            font-weight: bold;
            color: #495057;
            margin-bottom: 5px;
        }
        .car-detail-value {
            color: #212529;
        }
        .car-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 15px;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            overflow: hidden;
        }
        .car-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .password-error {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 5px;
        }
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-radius: 50%;
            border-top: 3px extreme #3498db;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        #favorites {
  max-width: 900px;
  margin: 20px auto;
  padding: 20px;
  background: #f9f9f9;
  border-radius: 8px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

#favorites h2 {
  font-size: 28px;
  margin-bottom: 15px;
  color: #333;
  border-bottom: 2px solid #4CAF50;
  padding-bottom: 8px;
}

#favorites form {
  margin-bottom: 15px;
  text-align: right;
}

#favorites select.form-select {
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 14px;
  background-color: white;
  cursor: pointer;
  transition: border-color 0.3s ease;
}

#favorites select.form-select:hover,
#favorites select.form-select:focus {
  border-color: #4CAF50;
  outline: none;
}

#favorites table {
  width: 100%;
  border-collapse: collapse;
  background-color: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

#favorites table thead {
  background-color: #4CAF50;
  color: white;
}

#favorites table th,
#favorites table td {
  text-align: left;
  padding: 12px 15px;
  border-bottom: 1px solid #ddd;
  font-size: 14px;
}

#favorites table tbody tr:hover {
  background-color: #f1f7f1;
}

#favorites p {
  font-style: italic;
  color: #666;
  text-align: center;
  margin-top: 40px;
}

    </style>
</head>
<body>
    <div class="sidebar">
        <a href="{{ route('home') }}">Return Home</a>
        <a href="{{ route("all-cars") }}" class="">Returh Cars</a>
        <h3 class="text-center text-white">User Panel</h3>
        <a href="#cars" class="nav-link">Cars</a>
        <a href="#profile" class="nav-link">Profile</a>
        <a href="#transactions" class="nav-link">Transactions</a>
        <a href="#favorites" class="nav-link">Favorites</a>
        <a href="#sellbuy" class="nav-link">Sell & Buys</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">🚪 Logout</button>
        </form>
    </div>

    <div class="content">
        <div class="header">
            <span>User Dashboard</span>
        </div>

        <div id="notification" class="notification"></div>

        <div id="cars" class="content-section active">
            <h2>{{ $user->UserName }}'s Cars</h2>

            @if(!empty($totalCarCount))
                <p class="text-muted">Total Cars: {{ $totalCarCount }}</p>
            @endif

            <button class="btn btn-primary mb-3" onclick="showAddCarModal()"> + Add new Car</button>

       <!-- In the search section of UserPannel.blade.php, replace the form with: -->
<div class="sort-search-container">
    <label for="sortBy" class="form-label">Sort By:</label>
    <select name="sort" class="form-select select-input" onchange="sortCars(this.value)">
        <option value="none" {{ $sortBy == "none" ? 'selected':''}}>None</option>
        <option value="price_asc" {{ $sortBy == 'price_asc' ? 'selected' : ''}}>Price: Low to High</option>
        <option value="price_desc" {{ $sortBy =='price_desc' ? 'selected' :'' }}>Price: High to Low</option>
        <option value="name_asc" {{ $sortBy =='name_asc' ? 'selected':'' }}>Name: A to Z</option>
        <option value="name_desc" {{ $sortBy =='name_desc' ? 'selected' : '' }}>Name: Z to A</option>
    </select>

    <label for="search" class="form-label">Search:</label>
    <label for="searchInput" class="form-label">Search:</label>
    <form method="GET" action="{{ route('cars.search') }}" id="searchForm">
        <input 
            type="text" 
            id="searchInput" 
            name="search" 
            class="form-control search-input" 
            placeholder="Search cars..." 
            value="{{ $searchTerm ?? '' }}" 
            oninput="handleSearchInput()"
        >
        <input type="hidden" name="sort" id="hiddenSort" value="{{ $sortBy }}">
        <input type="hidden" name="sort2" value="{{ $sortByFav ?? 'none' }}">
        <input type="hidden" name="active_section" value="cars">
        {{-- <button type="submit" class="btn btn-primary" style="border-radius:25px">Search</button> --}}
    </form>

    <form method='POST' action="{{ route('delete.all') }}">
        @csrf
        <button type='submit' class="btn btn-danger action-btn" onclick="return confirm('Are you sure you want to delete ALL cars? This cannot be undone!')">
            Delete All Cars
        </button>
    </form>
</div>

            <table class="table car-table">
                <thead>
                    <tr>
                        <th>Car Name</th>
                        <th>Price</th>
                        <th>Engine</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->cars as $car)
                    <tr>
                        <td>{{ $car->name }}</td>
                        <td>${{ number_format($car->price) }}</td>
                        <td>{{ $car->engine }}</td>
                        <td>
                            <button class="btn details-btn" onclick="showCarDetails({{ $car->id }}, '{{ addslashes($car->name) }}', {{ $car->price }}, '{{ addslashes($car->engine) }}', '{{ addslashes($car->discription) }}', '{{ $car->gallery_image ?? '' }}')">Show Details</button>
                            <form action="{{ route('delete.car') }}" method="POST" style="display: inline-block;">
                                @csrf
                                <input type="hidden" name="car_id" value="{{ $car->car_id }}">
                                <button type="submit" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this car?')">Delete Car</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            @if(!empty($searchTerm))
                                No cars found matching "{{ $searchTerm }}" ({{ $totalCarCount }} total cars)
                            @else
                                No cars found for this user
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="profile" class="content-section">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($user->UserName, 0, 1)) }}
                    </div>
                    <div class="profile-info">
                        <h2>{{ $user->UserName }}</h2>
                        <p>{{ $user->email }}</p>
                        <p>Member since: {{ $user->created_at->format('F Y') }}</p>
                    </div>
                </div>

                <ul class="profile-menu">
                    <li class="profile-menu-item">
                        <a href="#" class="profile-menu-link" onclick="showProfileSection('change-password')">
                            <span><i class="fas fa-key"></i> Change Password</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                    <li class="profile-menu-item">
                        <a href="#" class="profile-menu-link" onclick="showProfileSection('personal-info')">
                            <span><i class="fas fa-user"></i> Personal Information</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                    <li class="profile-menu-item">
                        <a href="#" class="profile-menu-link" onclick="showProfileSection('privacy-settings')">
                            <span><i class="fas fa-shield-alt"></i> Privacy Settings</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                    <li class="profile-menu-item">
                        <a href="#" class="profile-menu-link" onclick="showProfileSection('email-preferences')">
                            <span><i class="fas fa-envelope"></i> Email Preferences</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>

                <div class="danger-zone">
                    <h3><i class="fas fa-exclamation-triangle"></i> Danger extreme</h3>
                    <p>Once you delete your account, there is no going back. Please be certain.</p>
                    <button class="danger-btn" onclick="showProfileSection('delete-account')">
                        <i class="fas fa-trash-alt"></i> Delete Account
                    </button>
                </div>
            </div>

            <div id="change-password" class="profile-subsection" style="display: none;">
                <h3><i class="fas fa-key"></i> Change Password</h3>
                <form method="POST" action="{{ route('change-password') }}" id="passwordForm">
                    @csrf
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="password-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="new_password extreme" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required minlength="8">
                        @error('new_password')
                            <div class="password-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required minlength="8">
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Update Password</button>
                        <button type="button" class="btn btn-secondary" onclick="hideProfileSection('change-password')">Cancel</button>
                    </div>
                </form>
            </div>

            <div id="personal-info" class="profile-subsection" style="display: none;">
                <h3><i class="fas fa-user"></i> Personal Information</h3>
                <form method="POST" action="{{ route("account-change") }}" id="personalInfoForm">
                    @csrf
                    <div class="mb-3">
                        <label for="userName" class="form-label">Username</label>
                        <input type="text" class="form-control" id="userName" name="username" value="{{ $user->UserName }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone_number" placeholder="Enter your phone number" value="{{ $user->phone_number }}">
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" onclick="hideProfileSection('personal-info')">Cancel</button>
                    </div>
                </form>
            </div>

            <div id="privacy-settings" class="profile-subsection" style="display: none;">
                <h3><i class="fas fa-shield-alt"></i> Privacy Settings</h3>
                <form id="privacyForm" onsubmit="updatePrivacySettings(event)">
                    @csrf
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="profileVisibility" name="profile_visibility">
                        <label class="form-check-label" for="profileVisibility">Make my profile public</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="showEmail" name="show_email">
                        <label class="form-check-label" for="showEmail">Show email address to other users</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="showPhone" name="show_phone">
                        <label class="form-check-label" for="showPhone">Show phone number to other users</label>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                        <button type="button" class="btn btn-secondary" onclick="hideProfileSection('privacy-settings')">Cancel</button>
                    </div>
                </form>
            </div>

            <div id="email-preferences" class="profile-subsection" style="display: none;">
                <h3><i class="fas fa-envelope"></i> Email Preferences</h3>
                <form id="email extreme" onsubmit="updateEmailPreferences(event)">
                    @csrf
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" extreme="newsletter" name="newsletter" checked>
                        <label class="form-check-label" for="newsletter">Subscribe to newsletter</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="promotional" name="promotional" checked>
                        <label class="form-check-label" for="promotional">Receive promotional offers</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="notifications" name="notifications" checked>
                        <label class="form-check-label" for="notifications">Receive notification emails</label>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save Preferences</button>
                        <button type="button" class="btn btn-secondary" onclick="hideProfileSection('email-preferences')">Cancel</button>
                    </div>
                </form>
            </div>

            <div id="delete-account" class="profile-subsection" style="display: none;">
                <h3><i class="fas fa-exclamation-triangle"></i> Delete Account</h3>
                <p>Are you sure you want to delete your account? This action cannot be undone. All your data will be permanently removed.</p>
                <form action="{{ route('delete.account') }}" method="POST" id="deleteAccountForm">
                    @csrf
                    <div class extreme="mb-3">
                        <label for="deletePassword" class="form-label">Enter your password to confirm</label>
                        <input type="password" class="form-control" id="deletePassword" name="deletePassword" required>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-danger">Permanently Delete My Account</button>
                        <button type="button" class="btn btn-secondary" onclick="hideProfileSection('delete-account')">Cancel</button>
                    </div>
                </form>

                @if(session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>

        <div id="transactions" class="content-section">
            <h2>Transactions</h2>
            <p>Details of the user's transactions.</p>
        </div>

  <div id="favorites" class="content-section">
    <h2>Favorites</h2>
    @if ($favcars->count() > 0)
        <form action="{{ route('profile-go', ['user_id' => Auth::user()->UserID]) }}" method="GET" id="favoritesSortForm">
            <input type="hidden" name="active_section" value="favorites">
            <input type="hidden" name="sort" value="{{ $sortBy ?? 'none' }}">
            @if(!empty($searchTerm))
                <input type="hidden" name="search" value="{{ $searchTerm }}">
            @endif
            <p class="sort-btn" style="text-align:left;">Sort By:</p>
            <select name="sort2" class="form-select select-input" onchange="this.form.submit()">
                <option value="none" {{ $sortByFav == 'none' ? 'selected' : '' }}>None</option>
                <option value="price_asc" {{ $sortByFav == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ $sortByFav == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                <option value='name_asc' {{ $sortByFav == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                <option value='name_desc' {{ $sortByFav == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
            </select>
        </form>
        <table class="table car-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Car Name</th>
                    <th>Price</th>
                    <th>Favorites Count</th>
                    <th>Engine</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($favcars as $index => $car)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $car->name }}</td>
                        <td>${{ number_format($car->price, 2) }}</td>
                        <td>{{ $car->fav_num }}</td>
                        <td>{{ $car->engine ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No favorite cars yet.</p>
    @endif
</div>

        <div id="sellbuy" class="content-section">
            <h2>Sell & Buys</h2>
            <p>Information related to selling and buying cars.</p>
        </div>
    </div>

    <div id="addCarModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Car</h2>
                <span class="close" onclick="closeModal('addCarModal')">&times;</span>
            </div>
            <div class="modal-body">
                <form id="addCarForm">
                    @csrf
                    <div class="mb-3">
                        <label for="carName" class="form-label">Car Name</label>
                        <input type="text" class="form-control" id="carName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="carPrice" class="form-label">Price ($)</label>
                        <input type="number" class="form-control" id="carPrice" name="price" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="carEngine" class="form-label">Engine</label>
                        <input type="text" class="form-control" id="carEngine" name="engine" required>
                    </div>
                    <div class="mb-3">
                        <label for="carDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="carDescription" name="description" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addCarModal')">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addCar()">Add Car</button>
            </div>
        </div>
    </div>

    <div id="carDetailsModal" class="modal car-details-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="carDetailsTitle">Car Details</h2>
                <span class="close" onclick="closeModal('carDetailsModal')">&times;</span>
            </div>
            <div class="modal-body">
                <div class="car-image" id="car-detail-image">
                    <i class="fas fa-car fa-3x"></i>
                </div>

                <div class="car-details-grid">
                    <div class="car-detail-item">
                        <div class="car-detail-label">Car Name</div>
                        <div class="car-detail-value" id="car-detail-name"></div>
                    </div>
                    <div class="car-detail-item">
                        <div class="car-detail-label">Price</div>
                        <div class="car-detail-value" id="car-detail-price"></div>
                    </div>
                    <div class="car-detail-item">
                        <div class="car-detail-label">Engine</div>
                        <div class="car-detail-value" id="car-detail-engine"></div>
                    </div>
                    <div class="car-detail-item">
                        <div class="car-detail-label">Car ID</div>
                        <div class="car-detail-value" id="car-detail-id"></div>
                    </div>
                </div>

                <div class="car-detail-item">
                    <div class="car-detail-label">Description</div>
                    <div class="car-detail-value" id="car-detail-description"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('carDetailsModal')">Close</button>
            </div>
        </div>
    </div>

    <script>
        function sortCars(sortValue) {
            const url = new URL(window.location);
            url.searchParams.set('sort', sortValue);
            url.searchParams.set('active_section', 'cars');
            window.location.href = url.toString();
        }

        function sortFavorites() {
            document.getElementById('favoritesSortForm').submit();
        }

        function setActiveSection(section) {
            const url = new URL(window.location);
            url.searchParams.set('active_section', section);
            window.history.replaceState({}, '', url);
        }

        const links = document.querySelectorAll('.nav-link');
        const sections = document.querySelectorAll('.content-section');

        links.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                links.forEach(link => link.classList.remove('active'));
                link.classList.add('active');
                const target = link.getAttribute('href').substring(1);
                sections.forEach(section => {
                    section.classList.remove('active');
                });
                document.getElementById(target).classList.add('active');
                setActiveSection(target);
            });
        });
        function sortCars(sortValue) {
    const url = new URL(window.location);
    url.searchParams.set('sort', sortValue);
    url.searchParams.set('active_section', 'cars');
    window.location.href = url.toString();
}

// Update the favorites sort form to include all necessary parameters
// Debounce timer variable to avoid too many submits while typing
let debounceTimer;

function handleSortChange() {
    const sortSelect = document.getElementById('sortSelect');
    const hiddenSort = document.getElementById('hiddenSort');
    const searchForm = document.getElementById('searchForm');

    // Update the hidden input for sort so it's submitted with the form
    hiddenSort.value = sortSelect.value;

    // Submit the form to apply sorting (with current search value)
    searchForm.submit();
}

function handleSearchInput() {
    const searchForm = document.getElementById('searchForm');

    // Clear previous timer
    clearTimeout(debounceTimer);

    // Wait 500ms after user stops typing before submitting
    debounceTimer = setTimeout(() => {
        searchForm.submit();
    }, 500);
}

document.addEventListener('DOMContentLoaded', function() {
    const favoritesForm = document.getElementById('favoritesSortForm');
    if (favoritesForm) {
        // Add hidden inputs to preserve other parameters
        const sortInput = document.createElement('input');
        sortInput.type = 'hidden';
        sortInput.name = 'sort';
        sortInput.value = '{{ $sortBy ?? "none" }}';
        favoritesForm.appendChild(sortInput);

        const searchInput = document.createElement('input');
        searchInput.type = 'hidden';
        searchInput.name = 'search';
        searchInput.value = '{{ $searchTerm ?? "" }}';
        favoritesForm.appendChild(searchInput);
    }
});
        document.getElementById('cars').classList.add('active');
        document.querySelector('.nav-link[href="#cars"]').classList.add('active');

        function showProfileSection(sectionId) {
            document.querySelectorAll('.profile-subsection').forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';
            document.getElementById(sectionId).scrollIntoView({ behavior: 'smooth' });
        }
        // On page load, check for active_section parameter
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const activeSection = urlParams.get('active_section');

    if (activeSection) {
        // Hide all sections
        document.querySelectorAll('.content-section').forEach(section => {
            section.classList.remove('active');
        });

        // Remove active class from all links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active');
        });

        // Show the requested section
        document.getElementById(activeSection).classList.add('active');
        document.querySelector(`.nav-link[href="#${activeSection}"]`).classList.add('active');
    }
});
        function hideProfileSection(sectionId) {
            document.getElementById(sectionId).style.display = 'none';
        }

        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type}`;
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 5000);
        }

        function updatePassword(event) {
            event.preventDefault();
            showNotification('Password updated successfully!', 'success');
            hideProfileSection('change-password');
        }

        function updatePersonalInfo(event) {
            event.preventDefault();
            showNotification('Personal information updated successfully!', 'success');
            hideProfileSection('personal-info');
        }

        function updatePrivacySettings(event) {
            event.preventDefault();
            showNotification('Privacy settings updated successfully!', 'success');
            hideProfileSection('privacy-settings');
        }

        function updateEmailPreferences(event) {
            event.preventDefault();
            showNotification('Email preferences updated successfully!', 'success');
            hideProfileSection('email-preferences');
        }

        function deleteAccount(event) {
            event.preventDefault();
            if (confirm('Are you absolutely sure you want to delete your account? This cannot be undone!')) {
                showNotification('Your account has been deleted successfully.', 'success');
                setTimeout(() => {
                    window.location.href = '/';
                }, 2000);
            }
        }

        function showAddCarModal() {
            document.getElementById('addCarModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function addCar() {
            showNotification('Car added successfully!', 'success');
            closeModal('addCarModal');
        }

        function showCarDetails(carId, carName, carPrice, carEngine, carDescription, carImage) {
            document.getElementById('carDetailsTitle').textContent = carName + ' Details';
            document.getElementById('car-detail-name').textContent = carName || 'Not specified';
            document.getElementById('car-detail-price').textContent = carPrice ? '$' + Number(carPrice).toLocaleString() : 'Not specified';
            document.getElementById('car-detail-engine').textContent = carEngine || 'Not specified';
            document.getElementById('car-detail-id').textContent = carId || 'Not specified';
            document.getElementById('car-detail-description').textContent = carDescription || 'No description available';
            const carImageElement = document.getElementById('car-detail-image');
            if (carImage) {
                carImageElement.innerHTML = `<img src="${carImage}" alt="${carName}">`;
            } else {
                carImageElement.innerHTML = '<i class="fas fa-car fa-3x"></i>';
            }
            document.getElementById('carDetailsModal').style.display = 'block';
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }

        setTimeout(() => {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                flashMessage.style.display = 'none';
            }
        }, 5000);
    </script>
</body>
</html>
