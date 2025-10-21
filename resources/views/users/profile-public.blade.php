<x-layouts.homepage :title="$user->name . ' (@' . $user->username . ')'">
    <style>
        .profile-gradient-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 50%, #e0f2fe 100%);
        }
        
        .container {
            max-width: 900px;
            margin: 20px auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .profile-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #4f46e5 50%, #6366f1 100%);
            padding: 30px 30px 25px;
            text-align: center;
            position: relative;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            margin: 0 auto 10px;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
            font-weight: bold;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-name {
            font-size: 28px; 
            font-weight: 700;
            color: white;
            margin-bottom: 1px;
        }

        .profile-username {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 6px;
        }

        .profile-bio {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 6px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.4;
        }

        .profile-meta {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 10px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.85);
        }

        .stats-container {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-top: 15px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: white;
            display: block;
            margin-bottom: 2px;
        }

        .stat-label {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.85);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .follow-btn {
            margin-top: 12px;
            padding: 8px 24px;
            border: 2px solid white;
            background: transparent;
            color: white;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
        }

        .follow-btn:hover {
            background: white;
            color: #667eea;
        }

        .follow-btn.following {
            background: white;
            color: #667eea;
        }

        .posts-section {
            padding: 30px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 3px solid #3b82f6;
        }

        .post-card {
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1px solid #e2e8f0;
        }

        .post-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.15);
            border-color: #93c5fd;
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        .post-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 10px;
            overflow: hidden;
        }

        .post-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .post-info {
            flex: 1;
        }

        .post-author {
            font-weight: 600;
            color: #1e293b;
            font-size: 15px;
        }

        .post-time {
            font-size: 13px;
            color: #64748b;
        }

        .post-title {
            font-size: 36px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .post-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s;
        }

        .post-title a:hover {
            color: #3b82f6;
        }

        .post-content {
            color: #475569;
            line-height: 1.6;
            font-size: 15px;
            margin-bottom: 12px;
        }

        .post-image {
            width: 100%;
            max-height: 300px;
            border-radius: 8px;
            margin-bottom: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .post-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .post-actions {
            display: flex;
            gap: 15px;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
        }

        .action-btn {
            color: #64748b;
            font-size: 14px;
            cursor: pointer;
            transition: color 0.2s;
            text-decoration: none;
        }

        .action-btn:hover {
            color: #3b82f6;
        }

        .no-posts {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }

        .no-posts svg {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            opacity: 0.3;
            color: #94a3b8;
        }

        @media (max-width: 768px) {
            body {
                padding: 0;
            }

            .container {
                margin: 20px 10px;
            }

            .stats-container {
                gap: 20px;
            }

            .stat-number {
                font-size: 20px;
            }

            .posts-section {
                padding: 25px 15px;
            }

            .profile-header {
                padding: 30px 20px 25px;
            }

            .profile-name {
                font-size: 24px;
            }

            .profile-username {
                font-size: 15px;
            }

            .profile-picture {
                width: 100px;
                height: 100px;
                font-size: 40px;
            }
        }
    </style>

    <div class="profile-gradient-bg min-h-screen py-4">
        <div class="container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-picture">
                @if($user->avatar)
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                @else
                    {{ $user->initials() }}
                @endif
            </div>
            
            <h1 class="profile-name">{{ $user->name }}</h1>
            <p class="profile-username">{{ '@' . $user->username }}</p>
            
            @if($user->bio)
                <p class="profile-bio">{{ $user->bio }}</p>
            @endif

            <div class="profile-meta">
                @if($user->location)
                    <span>📍 {{ $user->location }}</span>
                @endif
                <span>📅 Joined {{ $user->created_at->format('M Y') }}</span>
            </div>
            
            <div class="stats-container">
                <div class="stat-item">
                    <span class="stat-number">{{ $user->posts()->count() }}</span>
                    <span class="stat-label">Posts</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $user->followers()->count() }}</span>
                    <span class="stat-label">Followers</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $user->following()->count() }}</span>
                    <span class="stat-label">Following</span>
                </div>
            </div>

            @auth
                @if(auth()->id() !== $user->id)
                    <button 
                        type="button" 
                        id="followBtn"
                        class="follow-btn {{ auth()->user()->isFollowing($user) ? 'following' : '' }}"
                        data-user-id="{{ $user->id }}"
                        data-following="{{ auth()->user()->isFollowing($user) ? 'true' : 'false' }}"
                        onclick="toggleFollow()"
                    >
                        <span id="followBtnText">{{ auth()->user()->isFollowing($user) ? 'Following' : 'Follow' }}</span>
                    </button>
                @endif
            @endauth
        </div>

        <!-- Recent Posts Section -->
        <div class="posts-section">
            <h2 class="section-title">Recent Posts</h2>

            @forelse($posts as $post)
                <div class="post-card">
                    <div class="post-header">
                        <div class="post-avatar">
                            @if($post->user->avatar)
                                <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}">
                            @else
                                {{ $post->user->initials() }}
                            @endif
                        </div>
                        <div class="post-info">
                            <div class="post-author">{{ $post->user->name }}</div>
                            <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
                        </div>
                    </div>

                    <div class="post-title">
                        <a href="{{ route('posts.show', ['username' => $post->user->username, 'slug' => $post->slug]) }}">
                            {{ $post->title }}
                        </a>
                    </div>

                    <div class="post-content">
                        {{ Str::limit(strip_tags($post->content), 200) }}
                    </div>

                    @if($post->featured_image)
                        <div class="post-image">
                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}">
                        </div>
                    @endif

                    <div class="post-actions">
                        <span class="action-btn">❤️ {{ $post->likes()->count() }} Likes</span>
                        <span class="action-btn">💬 {{ $post->comments()->count() }} Comments</span>
                        <a href="{{ route('posts.show', ['username' => $post->user->username, 'slug' => $post->slug]) }}" class="action-btn">📖 Read More</a>
                    </div>
                </div>
            @empty
                <div class="no-posts">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 10px; color: #555;">No posts yet</h3>
                    <p>{{ $user->name }} hasn't published any posts yet.</p>
                </div>
            @endforelse

            <!-- Pagination -->
            @if($posts->hasPages())
                <div style="margin-top: 30px;">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
    </div>

    <script>
        function toggleFollow() {
            const btn = document.getElementById('followBtn');
            const btnText = document.getElementById('followBtnText');
            const userId = btn.dataset.userId;
            const isFollowing = btn.dataset.following === 'true';
            const followersCount = document.querySelector('.stat-item:nth-child(2) .stat-number');
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('CSRF token not found');
                alert('Security token not found. Please refresh the page.');
                return;
            }
            
            // Disable button during request
            btn.disabled = true;
            btn.style.opacity = '0.6';
            const originalText = btnText.textContent;
            btnText.textContent = isFollowing ? 'Unfollowing...' : 'Following...';
            
            const url = `/users/${userId}/follow`;
            const method = isFollowing ? 'DELETE' : 'POST';
            
            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response:', data);
                if (data.success) {
                    // Toggle the state
                    const newFollowingState = !isFollowing;
                    btn.dataset.following = newFollowingState ? 'true' : 'false';
                    
                    // Update button appearance
                    if (newFollowingState) {
                        btn.classList.add('following');
                        btnText.textContent = 'Following';
                    } else {
                        btn.classList.remove('following');
                        btnText.textContent = 'Follow';
                    }
                    
                    // Update followers count
                    const currentCount = parseInt(followersCount.textContent);
                    followersCount.textContent = newFollowingState ? currentCount + 1 : currentCount - 1;
                } else {
                    throw new Error(data.message || 'Unknown error occurred');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                // Reset to original state
                btnText.textContent = isFollowing ? 'Following' : 'Follow';
            })
            .finally(() => {
                // Re-enable button
                btn.disabled = false;
                btn.style.opacity = '1';
            });
        }
    </script>
</x-layouts.homepage>
