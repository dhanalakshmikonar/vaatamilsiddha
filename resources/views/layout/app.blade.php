<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaatamilsiddha ERP | Modern Clinic Management</title>

    <!-- Favicon / Brand Logo -->
    <link rel="icon" type="image/png" href="/images/logo.png">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts: Plus Jakarta Sans, Outfit, Cormorant Garamond -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0f766e;
            --primary-dark: #042f2e;
            --primary-light: #14b8a6;
            --primary-subtle: #f0fdf4;
            --accent: #d97706;
            --accent-light: #fef3c7;
            --bg-app: #f8fafc;
            --sidebar-bg: #0b1523;
            --sidebar-card: #132238;
            --sidebar-text: #94a3b8;
            --sidebar-active: #ffffff;
            --surface: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --border-focus: #14b8a6;
            --shadow-xs: 0 1px 2px rgba(15, 23, 42, 0.05);
            --shadow-sm: 0 4px 12px rgba(15, 23, 42, 0.04);
            --shadow-md: 0 12px 24px -4px rgba(15, 23, 42, 0.08);
            --shadow-lg: 0 20px 36px -6px rgba(15, 23, 42, 0.12);
            --radius-sm: 10px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-full: 9999px;
            --transition-fast: 0.18s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-smooth: 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: var(--bg-app);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
        }

        body {
            background:
                radial-gradient(circle at 10% 5%, rgba(20, 184, 166, 0.07), transparent 30%),
                radial-gradient(circle at 90% 90%, rgba(14, 116, 144, 0.07), transparent 30%),
                linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        }

        /* App Layout Container */
        .app-container {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 270px;
            background: linear-gradient(180deg, #09121d 0%, #0d1b2e 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px 18px;
            flex-shrink: 0;
            position: relative;
            z-index: 20;
            border-right: 1px solid rgba(255, 255, 255, 0.07);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15);
            transition: var(--transition-smooth);
        }

        .sidebar-header {
            margin-bottom: 24px;
            padding: 0 4px;
        }

        .brand-logo-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: white;
        }

        .brand-logo-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.28);
            border: 2px solid rgba(20, 184, 166, 0.4);
            flex-shrink: 0;
        }

        .brand-logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 8px;
        }

        .brand-text-block h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.01em;
            color: #ffffff;
            line-height: 1.15;
        }

        .brand-text-block span {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }


        .clinic-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 14px;
            padding: 5px 12px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.25);
            border-radius: var(--radius-full);
            font-size: 11px;
            font-weight: 700;
            color: #34d399;
        }

        .status-dot-pulse {
            width: 7px;
            height: 7px;
            background-color: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-green 2s infinite;
        }

        @keyframes pulse-green {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            scrollbar-width: none;
            padding-right: 2px;
        }
        .sidebar-nav::-webkit-scrollbar { display: none; }

        .nav-section-label {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.1em;
            color: #475569;
            text-transform: uppercase;
            margin: 20px 8px 8px 8px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin-bottom: 6px;
        }

        .sidebar ul li a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 11px 14px;
            text-decoration: none;
            color: var(--sidebar-text);
            border-radius: var(--radius-md);
            font-size: 13.5px;
            font-weight: 600;
            letter-spacing: -0.01em;
            transition: var(--transition-fast);
            position: relative;
        }

        .sidebar ul li a i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            color: #64748b;
            transition: var(--transition-fast);
        }

        .sidebar ul li a:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
            transform: translateX(3px);
        }

        .sidebar ul li a:hover i {
            color: #14b8a6;
        }

        .sidebar ul li a.active {
            color: #ffffff;
            font-weight: 700;
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.22), rgba(15, 118, 110, 0.15));
            border: 1px solid rgba(20, 184, 166, 0.35);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        }

        .sidebar ul li a.active i {
            color: #2dd4bf;
        }

        .sidebar ul li a.active::before {
            content: '';
            position: absolute;
            left: -18px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: #14b8a6;
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 10px #14b8a6;
        }

        .sidebar-footer-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: var(--radius-md);
            padding: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 16px;
        }

        .sidebar-footer-card i {
            font-size: 20px;
            color: #14b8a6;
        }

        .sidebar-footer-card div p {
            font-size: 12px;
            font-weight: 700;
            color: white;
        }

        .sidebar-footer-card div span {
            font-size: 11px;
            color: #94a3b8;
        }

        /* Main Content Viewport */
        .main-viewport {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* Header Styling */
        .app-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 14px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(226, 232, 240, 0.85);
            position: sticky;
            top: 0;
            z-index: 15;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.02);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .mobile-toggle-btn {
            display: none;
            background: transparent;
            border: none;
            font-size: 20px;
            color: var(--text-main);
            cursor: pointer;
        }

        .brand-header-title {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 30px;
            font-weight: 700;
            letter-spacing: 0.02em;
            color: #064e3b;
            line-height: 1;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-header-title span.badge-tag {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11px;
            font-weight: 700;
            background: linear-gradient(135deg, #14b8a6, #0f766e);
            color: white;
            padding: 3px 8px;
            border-radius: 6px;
            letter-spacing: 0.04em;
        }

        .header-center-info {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f1f5f9;
            padding: 7px 14px;
            border-radius: var(--radius-full);
            border: 1px solid var(--border-color);
            font-size: 12.5px;
            font-weight: 600;
            color: #475569;
        }

        .header-center-info i {
            color: var(--primary);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .header-quick-action {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: linear-gradient(135deg, #14b8a6, #0f766e);
            color: white;
            padding: 8px 16px;
            border-radius: var(--radius-full);
            font-size: 12.5px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(20, 184, 166, 0.28);
            transition: var(--transition-fast);
        }

        .header-quick-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(20, 184, 166, 0.38);
        }

        .header-user-pill {
            padding: 6px 14px 6px 8px;
            border-radius: var(--radius-full);
            background: #ffffff;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: var(--shadow-xs);
        }

        .header-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d9488, #042f2e);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .header-user-name {
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
        }

        .logout-btn {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: 8px 14px;
            border-radius: var(--radius-full);
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition-fast);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .logout-btn:hover {
            background: #fecdd3;
            color: #9f1239;
            transform: translateY(-1px);
        }

        /* Scrollable Content Area */
        .content-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 28px 32px 40px 32px;
        }

        /* Global Toast Notifications */
        .toast-notification-wrap {
            position: fixed;
            top: 80px;
            right: 32px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }

        .toast-banner {
            pointer-events: auto;
            padding: 14px 20px;
            border-radius: var(--radius-md);
            font-size: 13.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.12);
            animation: slideInRight 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            max-width: 440px;
            border: 1px solid transparent;
        }

        .toast-success {
            background: #ffffff;
            color: #15803d;
            border-left: 5px solid #10b981;
            border-color: #bbf7d0 #bbf7d0 #bbf7d0 #10b981;
        }

        .toast-error {
            background: #ffffff;
            color: #b91c1c;
            border-left: 5px solid #ef4444;
            border-color: #fecaca #fecaca #fecaca #ef4444;
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Toolbar / Page Header Card */
        .toolbar-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            padding: 24px 28px;
            margin-bottom: 24px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            position: relative;
            overflow: hidden;
        }

        .toolbar-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #14b8a6, #0f766e, #d97706);
        }

        .toolbar-title h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .toolbar-title p {
            font-size: 13.5px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .toolbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Live Table Search Input */
        .search-box-wrap {
            position: relative;
            min-width: 260px;
        }

        .search-box-wrap input {
            width: 100%;
            padding: 10px 16px 10px 38px;
            border-radius: var(--radius-full);
            border: 1px solid var(--border-color);
            background: #f8fafc;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
            transition: var(--transition-fast);
            outline: none;
        }

        .search-box-wrap input:focus {
            background: #ffffff;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.12);
        }

        .search-box-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 13px;
        }

        /* Standard Buttons */
        .btn {
            background: linear-gradient(135deg, #14b8a6, #0f766e);
            color: white;
            padding: 10px 18px;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            box-shadow: 0 8px 18px rgba(15, 118, 110, 0.22);
            transition: var(--transition-fast);
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(15, 118, 110, 0.32);
            filter: brightness(1.04);
        }

        .ghost-btn {
            background: #ffffff;
            color: #475569;
            padding: 9px 16px;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            border: 1px solid var(--border-color);
            cursor: pointer;
            box-shadow: var(--shadow-xs);
            transition: var(--transition-fast);
        }

        .ghost-btn:hover {
            background: #f8fafc;
            color: var(--text-main);
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }

        .delete-btn {
            background: #fee2e2;
            color: #b91c1c;
            padding: 9px 16px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 700;
            border: 1px solid #fecaca;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition-fast);
        }

        .delete-btn:hover {
            background: #fecdd3;
            color: #991b1b;
            transform: translateY(-1px);
        }

        /* Upload Forms Inline */
        .upload-inline {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
            padding: 4px 8px;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
        }

        .upload-inline input[type="file"] {
            background: white;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 12px;
            color: #475569;
            cursor: pointer;
        }

        .upload-inline input[type="file"]::file-selector-button {
            margin-right: 10px;
            border: none;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
            padding: 6px 10px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 11px;
            cursor: pointer;
        }

        /* Cards and Tables */
        .card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            padding: 24px;
            margin-bottom: 24px;
        }

        .table-shell {
            width: 100%;
            overflow-x: auto;
            border-radius: var(--radius-md);
            border: 1px solid #eef2f6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13.5px;
        }

        table thead tr {
            background: #f8fafc;
            border-bottom: 1px solid var(--border-color);
        }

        table th {
            padding: 14px 18px;
            font-size: 11.5px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            white-space: nowrap;
        }

        table td {
            padding: 14px 18px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            vertical-align: middle;
        }

        table tbody tr {
            transition: var(--transition-fast);
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        table tbody tr:hover {
            background: #f8fbff;
        }

        /* Initial Avatar */
        .avatar-initial-chip {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
            color: white;
            background: linear-gradient(135deg, #0d9488, #0f766e);
            box-shadow: 0 2px 8px rgba(13, 148, 136, 0.25);
            flex-shrink: 0;
        }

        .patient-cell-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: var(--radius-full);
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.02em;
            white-space: nowrap;
        }

        .status-badge.scheduled {
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }

        .status-badge.confirmed {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .status-badge.completed {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .status-badge.cancelled {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: var(--radius-full);
            font-size: 11px;
            font-weight: 700;
        }

        .badge-pill.teal {
            background: #ccfbf1;
            color: #0f766e;
            border: 1px solid #99f6e4;
        }

        .badge-pill.gray {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        /* Table Action Buttons */
        .table-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .icon-action {
            width: 34px;
            height: 34px;
            border-radius: var(--radius-sm);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
            background: #ffffff;
            color: #475569;
            cursor: pointer;
            transition: var(--transition-fast);
            box-shadow: var(--shadow-xs);
        }

        .icon-action.view {
            color: #2563eb;
            border-color: #bfdbfe;
        }

        .icon-action.edit {
            color: #0d9488;
            border-color: #99f6e4;
        }

        .icon-action.delete {
            color: #e11d48;
            border-color: #fecdd3;
        }

        .icon-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
        }

        .icon-action.view:hover { background: #eff6ff; }
        .icon-action.edit:hover { background: #f0fdfa; }
        .icon-action.delete:hover { background: #fff1f2; }

        /* Forms Styling */
        .form-container {
            background: #ffffff;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            padding: 32px;
            max-width: 960px;
            margin: 0 auto;
        }

        .form-header {
            margin-bottom: 26px;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--border-color);
        }

        .form-header h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .form-header p {
            font-size: 13.5px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .form-section-title {
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: #064e3b;
            margin: 24px 0 14px 0;
            display: flex;
            align-items: center;
            gap: 8px;
            grid-column: 1 / -1;
            padding-bottom: 6px;
            border-bottom: 1px dashed var(--border-color);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-size: 12.5px;
            font-weight: 700;
            color: #334155;
            letter-spacing: -0.01em;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 11px 14px;
            border-radius: var(--radius-md);
            border: 1px solid #cbd5e1;
            background: #ffffff;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text-main);
            outline: none;
            transition: var(--transition-fast);
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.15);
        }

        .form-group input[readonly] {
            background: #f8fafc;
            color: #64748b;
            cursor: not-allowed;
        }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        /* Responsive Breakpoints */
        @media (max-width: 900px) {
            .app-container {
                flex-direction: column;
                height: auto;
                overflow-y: auto;
            }

            .sidebar {
                width: 100%;
                height: auto;
                padding: 16px;
            }

            .sidebar-nav {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .nav-section-label {
                display: none;
            }

            .main-viewport {
                height: auto;
                overflow: visible;
            }

            .content-scroll {
                overflow: visible;
                padding: 18px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="app-container">

    <!-- Modern Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div>
            <div class="sidebar-header">
                <a href="/" class="brand-logo-wrap">
                    <div class="brand-logo-box">
                        <img src="/images/logo.png" alt="Vaatamilsiddha Logo">
                    </div>
                    <div class="brand-text-block">
                        <h2>வாத்தமிழ்</h2>
                        <span>Vaatamilsiddha ERP</span>
                    </div>
                </a>
                <div class="clinic-status-pill">
                    <div class="status-dot-pulse"></div>
                    <span>Clinic Portal Active</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section-label">Main Menu</div>
                <ul>
                    <li>
                        <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
                            <i class="fa-solid fa-chart-pie"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="/appointments" class="{{ request()->is('appointments*') ? 'active' : '' }}">
                            <i class="fa-solid fa-calendar-check"></i>
                            <span>Appointments</span>
                        </a>
                    </li>
                </ul>

                <div class="nav-section-label">Clinical Care</div>
                <ul>
                    <li>
                        <a href="/patients" class="{{ request()->is('patients*') ? 'active' : '' }}">
                            <i class="fa-solid fa-user-injured"></i>
                            <span>Patients</span>
                        </a>
                    </li>
                    <li>
                        <a href="/doctors" class="{{ request()->is('doctors*') ? 'active' : '' }}">
                            <i class="fa-solid fa-user-doctor"></i>
                            <span>Doctors</span>
                        </a>
                    </li>
                    <li>
                        <a href="/certificates" class="{{ request()->is('certificates*') || request()->is('doctor-certifications*') ? 'active' : '' }}">
                            <i class="fa-solid fa-stamp"></i>
                            <span>Doctor Certification</span>
                        </a>
                    </li>
                </ul>

                <div class="nav-section-label">Pharmacy & Billing</div>
                <ul>
                    <li>
                        <a href="/medicines" class="{{ request()->is('medicines*') ? 'active' : '' }}">
                            <i class="fa-solid fa-capsules"></i>
                            <span>Medicines</span>
                        </a>
                    </li>
                    <li>
                        <a href="/billing" class="{{ request()->is('billing*') ? 'active' : '' }}">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            <span>Billing</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="sidebar-footer-card">
            <img src="/images/logo.png" alt="Logo" style="width:28px;height:28px;object-fit:contain;background:#fff;border-radius:6px;padding:2px;">
            <div>
                <p>வாத்தமிழ் சித்த</p>
                <span>அகமே மருந்து</span>
            </div>
        </div>
    </aside>

    <!-- Main Viewport -->
    <div class="main-viewport">
        
        <!-- Header -->
        <header class="app-header">
            <div class="header-left">
                <h1 class="brand-header-title">
                    <img src="/images/logo.png" alt="Vaatamilsiddha Logo" style="width:40px;height:40px;object-fit:contain;border-radius:10px;background:#fff;border:1px solid #e2e8f0;padding:2px;box-shadow:0 2px 8px rgba(15,23,42,0.08);">
                    <span>Vaatamilsiddha</span>
                    <span class="badge-tag">ERP</span>
                </h1>
            </div>


            <div class="header-center-info" id="liveClockWidget">
                <i class="fa-regular fa-clock"></i>
                <span id="liveClock">Loading time...</span>
            </div>

            <div class="header-right">
                <a href="/appointments/create" class="header-quick-action">
                    <i class="fa-solid fa-plus"></i> Quick Book
                </a>

                <div class="header-user-pill">
                    <div class="header-avatar">DN</div>
                    <span class="header-user-name">Dhanalakshmi Nainar</span>
                </div>

                <form method="POST" action="/logout" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn" title="Sign Out">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Global Toast Alerts -->
        @if (session('success') || session('error'))
        <div class="toast-notification-wrap">
            @if (session('success'))
            <div class="toast-banner toast-success" id="toastAlert">
                <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if (session('error'))
            <div class="toast-banner toast-error" id="toastAlert">
                <i class="fa-solid fa-circle-exclamation" style="font-size: 18px;"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif
        </div>
        @endif

        <!-- Scrollable Content -->
        <main class="content-scroll">
            @yield('content')
        </main>

    </div>

</div>

<!-- Client-side Scripts -->
<script>
    // Realtime Clock Widget
    function updateClock() {
        const now = new Date();
        const options = { 
            weekday: 'short', 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric', 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit',
            hour12: true 
        };
        const clockElem = document.getElementById('liveClock');
        if (clockElem) {
            clockElem.textContent = now.toLocaleString('en-US', options);
        }
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Auto-dismiss Toast Alerts after 4.5 seconds
    setTimeout(function() {
        const toast = document.getElementById('toastAlert');
        if (toast) {
            toast.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-10px)';
            setTimeout(() => toast.remove(), 500);
        }
    }, 4500);

    // Instant Client-side Table Filter Utility
    function filterTable(inputId, tableId) {
        const input = document.getElementById(inputId);
        const table = document.getElementById(tableId);
        if (!input || !table) return;

        const filter = input.value.toLowerCase().trim();
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            // Skip empty state row if present
            if (row.cells.length === 1 && row.cells[0].getAttribute('colspan')) continue;

            const text = row.textContent || row.innerText;
            if (text.toLowerCase().indexOf(filter) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }
</script>

@stack('scripts')

</body>
</html>
