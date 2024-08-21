@extends('layouts.app')

@section('navbar')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ url('/') }}">
        {{ config('app.name', 'Laravel') }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">Home</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item mr-3">
                <form action="{{ route('loginForm') }}" method="GET" class="d-inline">
                    <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('loginForm') }}'">
                        Login
                    </button>
                </form>
            </li>
            <li class="nav-item">
                <form action="{{ route('register') }}" method="GET" class="d-inline">
                    <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('register') }}'">
                        Register
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>

@endsection

@section('content')
<div class="container">
    <h2>User Listing</h2>

    <!-- Search and Filter Form -->
    <div class="form-inline mb-4">
        <input id="searchQuery" class="form-control mr-sm-2" type="search" placeholder="Search by Name" aria-label="Search">

        <select id="genderFilter" class="form-control mr-sm-2">
            <option value="">All</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <button id="filterButton" class="btn btn-primary" type="button">Filter</button>
    </div>

    <!-- User Listing -->
    <div id="userListing" class="row">
        <!-- User cards will be inserted here by JavaScript -->
    </div>

    <!-- Pagination Controls -->
    <nav>
        <ul class="pagination justify-content-center" id="paginationControls">
            <!-- Pagination buttons will be inserted here by JavaScript -->
        </ul>
    </nav>
</div>

<!-- Pass the fetched data to JavaScript -->
<script>
    const users = @json($users);
    const itemsPerPage = 10; // Number of items per page
    let currentPage = 1;
    let filteredUsers = users;

    // Function to render users
    function renderUsers(page = 1) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const paginatedUsers = filteredUsers.slice(start, end);
        const userListing = document.getElementById('userListing');
        userListing.innerHTML = '';

        if (paginatedUsers.length === 0) {
            userListing.innerHTML = '<p>No users found matching your criteria.</p>';
            return;
        }

        paginatedUsers.forEach(user => {
            const userCard = `
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="${user.picture.medium}" class="card-img-top" alt="${user.name.first}">
                        <div class="card-body">
                            <h5 class="card-title">${user.name.first} ${user.name.last}</h5>
                            <p class="card-text">${user.email}</p>
                            <a target="_blank" href="/profile/${user.login.uuid}" class="btn btn-primary">View Profile</a>
                        </div>
                    </div>
                </div>
            `;
            userListing.innerHTML += userCard;
        });

        renderPagination(page);
    }

    // Function to filter users
    function filterUsers() {
        const query = document.getElementById('searchQuery').value.toLowerCase();
        const gender = document.getElementById('genderFilter').value;

        filteredUsers = users.filter(user => {
            const fullName = `${user.name.first} ${user.name.last}`.toLowerCase();
            const matchesName = fullName.includes(query);
            const matchesGender = gender ? user.gender === gender : true;

            return matchesName && matchesGender;
        });

        currentPage = 1; // Reset to the first page when filters are applied
        renderUsers(currentPage);
    }

    // Function to render pagination controls
    function renderPagination(currentPage) {
        console.log(currentPage);
        const totalPages = Math.ceil(filteredUsers.length / itemsPerPage);
        const paginationControls = document.getElementById('paginationControls');
        paginationControls.innerHTML = '';

        if (totalPages <= 1) return; // No pagination if there is just one page

        for (let i = 1; i <= totalPages; i++) {
            const isActive = i === currentPage ? 'active' : '';
            const pageButton = `<li class="page-item ${isActive}"><a class="page-link" href="#" onclick="goToPage(${i})">${i}</a></li>`;
            paginationControls.innerHTML += pageButton;
        }
    }

    // Function to navigate to a specific page
    function goToPage(page) {
        currentPage = page;
        renderUsers(currentPage);
    }

    // Initial render
    renderUsers(currentPage);

    // Event listener for filter button, Not really needed
    document.getElementById('filterButton').addEventListener('click', filterUsers);

    // Filter as you change gender
    document.getElementById('searchQuery').addEventListener('input', filterUsers);
    document.getElementById('genderFilter').addEventListener('change', filterUsers);
</script>
@endsection
