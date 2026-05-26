@extends('user.layouts.app')
@section('title', 'Pengaturan Akun')

@section('content')

    <style>
        .pg-greeting {
            margin-bottom: 28px;
        }

        .pg-greeting h1 {
            font-size: 26px;
            font-weight: 800;
            color: #111;
            letter-spacing: -0.02em;
            margin-bottom: 3px;
        }

        .pg-greeting p {
            font-size: 13px;
            color: #aaa;
            line-height: 1.6;
        }

        .pg-stack {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Card */
        .pf-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #f0f0ee;
            overflow: hidden;
        }

        .pf-card-head {
            padding: 18px 24px;
            border-bottom: 1px solid #f0f0ee;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pf-card-bar {
            width: 3px;
            height: 15px;
            background: #111;
            border-radius: 2px;
            flex-shrink: 0;
        }

        .pf-card-head h2 {
            font-size: 13.5px;
            font-weight: 700;
            color: #111;
            margin: 0;
        }

        .pf-card-head p {
            font-size: 11px;
            color: #bbb;
            margin-top: 2px;
        }

        .pf-card-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .pf-card-foot {
            padding: 16px 24px;
            border-top: 1px solid #f0f0ee;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Fields */
        .pf-label {
            display: block;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #aaa;
            margin-bottom: 7px;
        }

        .pf-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e8e8e6;
            border-radius: 10px;
            font-size: 13px;
            font-family: inherit;
            color: #111;
            background: #fff;
            outline: none;
            transition: border-color 0.15s;
        }

        .pf-input:focus {
            border-color: #111 !important;
            outline: none !important;
            box-shadow: none !important;
            ring: 0 !important;
        }

        .pf-input-error {
            font-size: 11px;
            color: #b91c1c;
            margin-top: 5px;
        }

        /* Verify box */
        .pf-verify-box {
            background: #fffbe6;
            border: 1px solid #f5e08a;
            border-radius: 9px;
            padding: 10px 14px;
            margin-top: 8px;
            font-size: 12px;
            color: #92400e;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            flex-wrap: wrap;
        }

        .pf-verify-btn {
            font-size: 11px;
            font-weight: 700;
            color: #c89a00;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            text-decoration: underline;
            padding: 0;
        }

        .pf-verify-btn:hover {
            color: #111;
        }

        .pf-sent-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            color: #1d8a45;
            background: #e8f7ee;
            border-radius: 6px;
            padding: 5px 10px;
            margin-top: 8px;
        }

        /* Buttons */
        .pf-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            padding: 10px 22px;
            cursor: pointer;
            font-family: inherit;
            letter-spacing: 0.03em;
            transition: background 0.13s;
        }

        .pf-btn-primary {
            background: #111;
            color: #fff;
        }

        .pf-btn-primary:hover {
            background: #333;
        }

        .pf-btn-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .pf-btn-danger:hover {
            background: #fecaca;
        }

        .pf-btn-secondary {
            background: #f5f5f3;
            color: #555;
            border: 1.5px solid #e8e8e6;
        }

        .pf-btn-secondary:hover {
            background: #eee;
        }

        .pf-saved-tag {
            font-size: 11px;
            font-weight: 600;
            color: #1d8a45;
            background: #e8f7ee;
            border-radius: 6px;
            padding: 4px 10px;
        }

        /* Danger zone */
        .pf-card-bar-red {
            background: #b91c1c;
        }

        .pf-danger-text {
            font-size: 12.5px;
            color: #777;
            line-height: 1.6;
        }

        /* Modal overlay */
        .pf-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(3px);
            z-index: 200;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .pf-modal {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #f0f0ee;
            padding: 28px;
            max-width: 440px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .pf-modal h3 {
            font-size: 15px;
            font-weight: 800;
            color: #111;
            letter-spacing: -0.01em;
            margin-bottom: 8px;
        }

        .pf-modal p {
            font-size: 12.5px;
            color: #888;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .pf-modal-foot {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .pf-warn-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            background: #fee2e2;
            color: #b91c1c;
            border-radius: 6px;
            padding: 4px 9px;
            margin-bottom: 14px;
        }
    </style>

    {{-- Greeting --}}
    <div class="pg-greeting">
        <h1>Pengaturan Akun</h1>
        <p>Kelola informasi profil, keamanan, dan preferensi akun Anda.</p>
    </div>

    <div class="pg-stack">
        @include('profile.partials.update-profile-information-form')
        @include('profile.partials.update-password-form')
        @include('profile.partials.delete-user-form')
    </div>

@endsection
