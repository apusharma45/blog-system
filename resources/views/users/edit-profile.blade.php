<x-layouts.homepage :title="'Profile Settings - ' . config('app.name')">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .edit-profile-wrapper {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .dark .edit-profile-wrapper {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .dark .header-card {
            background: #1e293b;
            border-color: #334155;
        }

        .header-card h1 {
            font-size: 2rem;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .dark .header-card h1 {
            color: #f1f5f9;
        }

        .header-card p {
            color: #64748b;
            font-size: 0.95rem;
        }

        .dark .header-card p {
            color: #94a3b8;
        }

        .success-message {
            background: #f0fdf4;
            border: 1px solid #86efac;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-message.hidden {
            display: none;
        }

        .error-message {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .error-message p {
            color: #991b1b;
            font-size: 0.875rem;
        }

        .success-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .success-icon {
            width: 32px;
            height: 32px;
            background: #22c55e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .success-text {
            color: #166534;
            font-weight: 500;
        }

        .close-btn {
            background: none;
            border: none;
            color: #22c55e;
            cursor: pointer;
            font-size: 1.5rem;
            padding: 0.25rem;
            line-height: 1;
        }

        .main-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .dark .main-card {
            background: #1e293b;
            border-color: #334155;
        }

        .tabs {
            display: flex;
            border-bottom: 1px solid #e2e8f0;
        }

        .dark .tabs {
            border-bottom-color: #334155;
        }

        .tab {
            flex: 1;
            padding: 1.25rem 1.5rem;
            background: none;
            border: none;
            font-weight: 500;
            font-size: 0.95rem;
            cursor: pointer;
            color: #64748b;
            border-bottom: 2px solid transparent;
            transition: all 0.3s;
        }

        .dark .tab {
            color: #94a3b8;
        }

        .tab:hover {
            background: #f8fafc;
            color: #0f172a;
        }

        .dark .tab:hover {
            background: #0f172a;
            color: #f1f5f9;
        }

        .tab.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
            background: #eff6ff;
        }

        .dark .tab.active {
            background: #1e3a8a;
            color: #93c5fd;
        }

        .tab-content {
            padding: 2rem;
        }

        .tab-panel {
            display: none;
        }

        .tab-panel.active {
            display: block;
        }

        .avatar-section {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 1.5rem;
        }

        .dark .avatar-section {
            border-bottom-color: #334155;
        }

        .avatar-wrapper {
            position: relative;
        }

        .avatar {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .dark .avatar {
            border-color: #334155;
        }

        .avatar-upload {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 32px;
            height: 32px;
            background: #2563eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            transition: background 0.3s;
        }

        .avatar-upload:hover {
            background: #1d4ed8;
        }

        .avatar-upload svg {
            width: 16px;
            height: 16px;
            color: white;
        }

        .avatar-upload input {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .avatar-info h3 {
            font-size: 1rem;
            color: #0f172a;
            margin-bottom: 0.25rem;
        }

        .dark .avatar-info h3 {
            color: #f1f5f9;
        }

        .avatar-info p {
            font-size: 0.875rem;
            color: #64748b;
        }

        .dark .avatar-info p {
            color: #94a3b8;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #334155;
            margin-bottom: 0.5rem;
        }

        .dark .form-group label {
            color: #cbd5e1;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            width: 18px;
            height: 18px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="url"],
        textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s;
            font-family: inherit;
            background: white;
            color: #0f172a;
        }

        .dark input[type="text"],
        .dark input[type="email"],
        .dark input[type="password"],
        .dark input[type="url"],
        .dark textarea {
            background: #0f172a;
            border-color: #475569;
            color: #f1f5f9;
        }

        .input-wrapper input {
            padding-left: 2.75rem;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        textarea {
            resize: none;
            min-height: 100px;
        }

        .char-count {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #64748b;
        }

        .dark .char-count {
            color: #94a3b8;
        }

        .section-divider {
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
            margin-top: 1.5rem;
        }

        .dark .section-divider {
            border-top-color: #334155;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 1rem;
        }

        .dark .section-title {
            color: #f1f5f9;
        }

        .info-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .dark .info-box {
            background: #1e3a8a;
            border-color: #1e40af;
        }

        .info-box p {
            font-size: 0.875rem;
            color: #1e40af;
            line-height: 1.5;
        }

        .dark .info-box p {
            color: #93c5fd;
        }

        .info-box strong {
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
            margin-top: 2rem;
        }

        .dark .action-buttons {
            border-top-color: #334155;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: white;
            color: #334155;
            border: 1px solid #cbd5e1;
        }

        .dark .btn-secondary {
            background: #0f172a;
            color: #cbd5e1;
            border-color: #475569;
        }

        .btn-secondary:hover {
            background: #f8fafc;
        }

        .dark .btn-secondary:hover {
            background: #1e293b;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn svg {
            width: 18px;
            height: 18px;
        }

        .danger-zone {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .dark .danger-zone {
            background: #450a0a;
            border-color: #991b1b;
        }

        .danger-zone h3 {
            color: #991b1b;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .dark .danger-zone h3 {
            color: #fca5a5;
        }

        .danger-zone p {
            color: #b91c1c;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .dark .danger-zone p {
            color: #f87171;
        }

        .field-error {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem 0.5rem;
            }

            .header-card,
            .tab-content {
                padding: 1.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .tabs {
                flex-direction: column;
            }

            .tab {
                border-bottom: 1px solid #e2e8f0;
                border-right: none;
            }

            .dark .tab {
                border-bottom-color: #334155;
            }

            .tab.active {
                border-bottom-color: #2563eb;
            }

            .avatar-section {
                flex-direction: column;
                text-align: center;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                justify-content: center;
            }
        }
    </style>

    <div class="edit-profile-wrapper {{ request()->cookie('dark_mode') ? 'dark' : '' }}">
        <div class="container">
            <!-- Header -->
            <div class="header-card">
                <h1>Profile Settings</h1>
                <p>Manage your account information and preferences</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="success-message" id="successMessage">
                <div class="success-content">
                    <div class="success-icon">✓</div>
                    <span class="success-text">{{ session('success') }}</span>
                </div>
                <button class="close-btn" onclick="document.getElementById('successMessage').classList.add('hidden')">×</button>
            </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="error-message">
            <ul style="list-style: none; padding: 0; margin: 0;">
                @foreach($errors->all() as $error)
                <p style="margin-bottom: 0.5rem;">• {{ $error }}</p>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Main Card -->
        <div class="main-card">
            <!-- Tabs -->
            <div class="tabs">
                <button class="tab active" data-tab="profile">Profile Information</button>
                <button class="tab" data-tab="security">Security</button>
            </div>

            <!-- Profile Tab Content -->
            <div class="tab-content">
                <div class="tab-panel active" id="profile-panel">
                    <form action="{{ route('profile.update', ['username' => auth()->user()->username]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Avatar Section -->
                        <div class="avatar-section">
                            <div class="avatar-wrapper">
                                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="avatar" id="avatarPreview">
                                <div class="avatar-upload">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <input type="file" name="avatar" accept="image/*" onchange="previewAvatar(event)">
                                </div>
                            </div>
                            <div class="avatar-info">
                                <h3>Profile Picture</h3>
                                <p>Upload a new avatar (JPG, PNG, max 2MB)</p>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="form-group">
                            <label>Full Name</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                            </div>
                            @error('name')
                            <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" value="{{ old('username', auth()->user()->username) }}" required>
                            @error('username')
                            <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label>Email Address</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                            </div>
                            @error('email')
                            <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div class="form-group">
                            <label>Bio</label>
                            <textarea name="bio" placeholder="Tell us about yourself..." maxlength="500" oninput="updateCharCount(this)">{{ old('bio', auth()->user()->bio) }}</textarea>
                            <div class="char-count"><span id="charCount">{{ strlen(auth()->user()->bio ?? '') }}</span> / 500 characters</div>
                            @error('bio')
                            <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="location" value="{{ old('location', auth()->user()->location) }}" placeholder="New York, USA">
                            @error('location')
                            <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button type="submit" class="btn btn-primary">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Save Changes
                            </button>
                            <a href="{{ route('dashboard', ['username' => auth()->user()->username]) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>

                <!-- Security Tab Content -->
                <div class="tab-panel" id="security-panel">
                    <form action="{{ route('profile.password.update', ['username' => auth()->user()->username]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="info-box">
                            <p><strong>Password Requirements:</strong> Your password must be at least 8 characters long and include a mix of uppercase, lowercase, numbers, and special characters.</p>
                        </div>

                        <!-- Current Password -->
                        <div class="form-group">
                            <label>Current Password</label>
                            <input type="password" name="current_password" required>
                            @error('current_password')
                            <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="password" required>
                            @error('password')
                            <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <input type="password" name="password_confirmation" required>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button type="submit" class="btn btn-primary">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Update Password
                            </button>
                        </div>

                        <!-- Danger Zone -->
                        <div class="danger-zone">
                            <h3>⚠️ Danger Zone</h3>
                            <p>Once you delete your account, there is no going back. This will permanently delete your account, all your posts, comments, and associated data.</p>
                            <button type="button" class="btn btn-danger" onclick="if(confirm('Are you sure you want to delete your account? This action cannot be undone!')) { document.getElementById('deleteForm').submit(); }">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete My Account
                            </button>
                        </div>
                    </form>

                    <!-- Hidden Delete Form -->
                    <form id="deleteForm" action="{{ route('profile.destroy', ['username' => auth()->user()->username]) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                        <input type="password" name="password" value="temp">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab Switching
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs and panels
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // Show corresponding panel
                const tabName = this.getAttribute('data-tab');
                document.getElementById(tabName + '-panel').classList.add('active');
            });
        });

        // Avatar Preview
        function previewAvatar(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        // Character Count
        function updateCharCount(textarea) {
            const count = textarea.value.length;
            document.getElementById('charCount').textContent = count;
        }

        // Auto-hide success message after 5 seconds
        setTimeout(() => {
            const successMsg = document.getElementById('successMessage');
            if (successMsg) {
                successMsg.classList.add('hidden');
            }
        }, 5000);
    </script>
    </div>
    </div>
</x-layouts.homepage>
