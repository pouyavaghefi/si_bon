<div class="row justify-content-center py-5">
    <div class="col-xxl-6 col-xl-7 text-center">

        <div class="avatar avatar-lg mx-auto mb-3">
            <div class="avatar-title bg-primary-subtle text-primary rounded-circle shadow-sm">
                <i data-lucide="server" class="fs-2"></i>
            </div>
        </div>

        <span class="badge badge-default fw-normal shadow-sm px-3 py-2 mb-3 fst-italic fs-xxs">
            <i data-lucide="calendar-days" class="fs-sm me-1"></i>
            {{ now()->format('l, F j Y') }}
        </span>

        <h2 class="fw-bold mb-3">
            Welcome Back, {{ auth()->user()->member()->first_name  ?? 'Administrator' }} 👋
        </h2>

        <p class="fs-md text-muted mb-4 px-lg-5">

        </p>

        <div class="row g-3 justify-content-center mt-2">

            <!-- Server IP -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-start">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                    <i data-lucide="globe"></i>
                                </div>
                            </div>

                            <div>
                                <h6 class="mb-0 fw-semibold">Server IP</h6>
                                <small class="text-muted">Public Address</small>
                            </div>
                        </div>

                        <div class="fw-bold fs-5">
                            {{ request()->server('SERVER_ADDR') ?? '127.0.0.1' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Local IP -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-start">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                    <i data-lucide="monitor-smartphone"></i>
                                </div>
                            </div>

                            <div>
                                <h6 class="mb-0 fw-semibold">Local IP</h6>
                                <small class="text-muted">Client Address</small>
                            </div>
                        </div>

                        <div class="fw-bold fs-5">
                            {{ request()->ip() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Local Time -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-start">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-title bg-warning-subtle text-warning rounded-circle">
                                    <i data-lucide="clock-3"></i>
                                </div>
                            </div>

                            <div>
                                <h6 class="mb-0 fw-semibold">Local Time</h6>
                                <small class="text-muted">Browser Time</small>
                            </div>
                        </div>

                        <div class="fw-bold fs-5" id="localTime">
                            --:--
                        </div>
                    </div>
                </div>
            </div>

            <!-- Server Time -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-start">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-title bg-info-subtle text-info rounded-circle">
                                    <i data-lucide="timer-reset"></i>
                                </div>
                            </div>

                            <div>
                                <h6 class="mb-0 fw-semibold">Server Time</h6>
                                <small class="text-muted">System Time</small>
                            </div>
                        </div>

                        <div class="fw-bold fs-5">
                            {{ now()->format('H:i:s') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    function updateLocalTime() {
        const now = new Date();

        document.getElementById('localTime').innerHTML =
            now.toLocaleTimeString();
    }

    updateLocalTime();
    setInterval(updateLocalTime, 1000);
</script>
