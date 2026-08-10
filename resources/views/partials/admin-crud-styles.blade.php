<style>
    .vh-toolbar-card {
        background: #fff;
        border-radius: 1.25rem;
        box-shadow: 0 4px 24px rgba(15, 34, 53, 0.06);
        padding: 1rem 1.35rem;
    }
    .vh-toolbar-inner {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.75rem;
    }
    .vh-search-wrap {
        position: relative;
        flex: 1;
        min-width: 200px;
        max-width: 440px;
    }
    .vh-search-wrap .bi-search {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.95rem;
        pointer-events: none;
    }
    .vh-search-wrap input.form-control {
        padding-left: 2.5rem;
        border-radius: 999px;
        border: 1px solid #e2e8f0;
        background: #fafbfc;
    }
    .vh-filter-select {
        border-radius: 999px !important;
        border: 1px solid #e2e8f0 !important;
        min-width: 150px;
        background: #fafbfc;
        font-size: 0.875rem;
    }
    .vh-table-shell {
        background: #fff;
        border-radius: 1.25rem;
        box-shadow: 0 4px 24px rgba(15, 34, 53, 0.06);
        overflow: hidden;
    }
    .vh-table-shell .vh-inner-title {
        padding: 1.25rem 1.35rem 0;
        font-weight: 700;
        font-size: 1rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #0f2235;
    }
    .vh-table-shell table thead th {
        background: #f1f5f9 !important;
        color: #475569 !important;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 600;
        border-bottom: 1px solid #e2e8f0 !important;
    }
    .btn-vh-add {
        border-radius: 999px !important;
        background: #22c55e !important;
        border: none !important;
        font-weight: 600;
        padding: 0.5rem 1.25rem !important;
        white-space: nowrap;
    }
    .btn-vh-add:hover { background: #16a34a !important; color: #fff !important; }
    .btn-vh-edit {
        width: 38px;
        height: 38px;
        padding: 0 !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px !important;
        background: #f97316 !important;
        border: none !important;
        color: #fff !important;
    }
    .btn-vh-edit:hover { background: #ea580c !important; color: #fff !important; }
    .btn-vh-del {
        width: 38px;
        height: 38px;
        padding: 0 !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px !important;
        background: #ef4444 !important;
        border: none !important;
        color: #fff !important;
    }
    .btn-vh-del:hover { background: #dc2626 !important; color: #fff !important; }
    .badge-vh-pending { background: #ffedd5; color: #c2410c; font-weight: 600; border-radius: 999px; padding: 0.35rem 0.75rem; font-size: 0.78rem; }
    .badge-vh-tersedia { background: #dcfce7; color: #15803d; font-weight: 600; border-radius: 999px; padding: 0.35rem 0.75rem; font-size: 0.78rem; }
    .badge-vh-habis { background: #fee2e2; color: #b91c1c; font-weight: 600; border-radius: 999px; padding: 0.35rem 0.75rem; font-size: 0.78rem; }
    .badge-vh-user-active { background: #dcfce7; color: #15803d; font-weight: 600; border-radius: 999px; padding: 0.35rem 0.75rem; font-size: 0.78rem; }
    .badge-vh-user-inactive { background: #fee2e2; color: #b91c1c; font-weight: 600; border-radius: 999px; padding: 0.35rem 0.75rem; font-size: 0.78rem; }
    .badge-vh-riw-pending { background: #ffedd5; color: #c2410c; font-weight: 600; border-radius: 999px; padding: 0.35rem 0.75rem; font-size: 0.78rem; }
    .badge-vh-riw-selesai { background: #dcfce7; color: #15803d; font-weight: 600; border-radius: 999px; padding: 0.35rem 0.75rem; font-size: 0.78rem; }
    .badge-vh-riw-batal { background: #ffe4e6; color: #be123c; font-weight: 600; border-radius: 999px; padding: 0.35rem 0.75rem; font-size: 0.78rem; }
    .vh-pagination-wrap nav { display: flex; justify-content: center; margin-top: 1rem; }
</style>
