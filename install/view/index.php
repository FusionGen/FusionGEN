<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="FusionGEN is a free, open-source World of Warcraft content management system.">
        <meta name="author" content="Err0r">
        <link rel="icon" type="image/png" href="assets/images/favicon.png">
        <title>FusionGEN - Installation</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/install.css">
        <script src="assets/js/realms.js"></script>
        <script src="assets/js/jquery-3.7.1.min.js"></script>
        <script src="assets/js/jquery-validation/jquery.validate.min.js"></script>
        <script src="assets/js/jquery-validation/jquery.form.min.js"></script>
        <script src="assets/js/jquery-persist.js"></script>
    </head>
    <body>
        <div class="container install-box">
            <div class="card shadow">
                <div class="card-header text-center py-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div style="width: 40px;"></div>
                        <img src="assets/images/logo.png" style="height:75px;">
                        <button class="btn btn-outline-secondary btn-sm" id="darkModeToggle">
                            <i class="fa fa-moon-o"></i>
                        </button>
                    </div>

                    <div class="nav nav-pills nav-justified mt-3" id="installTabs">
                        <button class="nav-link active" id="introduction" disabled><i class="fa fa-circle-o me-1"></i> Introduction</button>
                        <button class="nav-link" id="requirements" disabled><i class="fa fa-circle-o me-1"></i> Requirements</button>
                        <button class="nav-link" id="general" disabled><i class="fa fa-circle-o me-1"></i> General</button>
                        <button class="nav-link" id="database" disabled><i class="fa fa-circle-o me-1"></i> Database</button>
                        <button class="nav-link" id="realms" disabled><i class="fa fa-circle-o me-1"></i> Realms</button>
                        <button class="nav-link" id="finished" disabled><i class="fa fa-circle-o me-1"></i> Finish</button>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div id="alert-container" class="px-4 pt-3"></div>

                    <div class="tab-content p-4">
                        <div class="tab-pane fade show active" id="introduction-tab">
                            <div class="text-center mb-4">
                                <h3>Welcome to FusionGEN!</h3>
                                <p>
                                    <b>Dear User</b>, This is <b>FusionGEN</b>. <br>A continuation project continued by fellow web-developers under the conditions of Open-Source. Many people loved FusionCMS, But time is evolving and FusionCMS has been idle for quite some time. We are here to bring up a new Open-Source Project to bring <b>you</b> an optimized and cared for CMS that will evolve over time with love and passion from its contributors. FusionGEN is still powered by the CodeIgniter Framework, its Original PHP Code, its Original HTML Code and its Original Javascript Code. What we are focusing on is improving it all. Making it stronger, faster and more Modern. <br><br>Thank you for downloading FusionGEN<br>Enjoy!
                                </p>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="button" class="btn btn-primary btn-lg form-next">
                                    <span class="loader d-none"><i class="fa fa-spinner fa-spin me-1"></i> Please wait...</span>
                                    <span class="button-text"><i class='fa fa-chevron-right'></i> Start the installer</span>
                                </button>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="requirements-tab">
                            <h6>1. Please configure your PHP settings to match following requirements:</h6>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>PHP Settings</th>
                                            <th>Current Version</th>
                                            <th>Min Version</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>PHP Version</td>
                                            <td><?php echo $current_php_version; ?></td>
                                            <td><?php echo $php_version_min; ?></td>
                                            <td class="text-center">
                                                <i class="status fa <?php echo $php_version_success ? 'fa-check-circle text-success' : 'fa-times-circle text-danger'; ?>"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h6 class="mt-4">2. Please make sure the extensions/settings listed below are installed/enabled:</h6>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th width="25%">Extension/settings</th>
                                            <th width="27%">Current Settings</th>
                                            <th>Required Settings</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $extensions = [
                                            ['MySQLi', $mysql_success], ['GD', $gd_success], ['cURL', $curl_success],
                                            ['GMP', $gmp_success], ['SOAP', $soap_success], ['MBString', $mbstring_success],
                                            ['OpenSSL', $openssl_success], ['Zip', $zip_success], ['XML', $xml_success]
                                        ];
                                        foreach($extensions as $ext): 
                                        ?>
                                        <tr>
                                            <td><?php echo $ext[0]; ?></td>
                                            <td><?php echo $ext[1] ? 'On' : 'Off'; ?></td>
                                            <td>On</td>
                                            <td class="text-center">
                                                <i class="status fa <?php echo $ext[1] ? 'fa-check-circle text-success' : 'fa-times-circle text-danger'; ?>"></i>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <h6 class="mt-4">3. Please make sure you have set the <strong>writable</strong> permission on the following folders/files:</h6>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <tbody>
                                        <?php foreach ($writeable_directories as $value) { ?>
                                        <tr>
                                            <td style="width:87%;"><?php echo $value; ?></td>
                                            <td class="text-center">
                                                <?php if (is_writeable(".." . $value)) { ?>
                                                    <i class="status fa fa-check-circle text-success"></i>
                                                <?php } else { $all_requirement_success = false; ?>
                                                    <i class="status fa fa-times-circle text-danger"></i>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-grid mt-4">
                                <button <?php if (!$all_requirement_success) echo "disabled"; ?> class="btn btn-primary btn-lg form-next">
                                    <i class='fa fa-chevron-right'></i> Next
                                </button>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="general-tab">
                            <form name="general-form" id="general-form" action="do_general.php" method="post" autocomplete="off">
                                <h6>Enter general settings</h6>
                                <hr>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="title">Website title</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" id="title" name="title" placeholder="My Desired Website Title">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="server_name">Server name</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" id="server_name" name="server_name" placeholder="My Desired Server Name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="realmlist">Realmlist</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" id="realmlist" name="realmlist" placeholder="logon.myserver.com">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="security_code">Admin Panel (ACP) Security Password</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" id="security_code" name="security_code">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="max_expansion">Max expansion</label>
                                    <div class="col-md-9">
                                        <select class="form-select" id="max_expansion" name="max_expansion">
                                            <option value="9">Dragonflight (10.x.x)</option>
                                            <option value="8">Shadowlands (9.x.x)</option>
                                            <option value="7">Battle for Azeroth (8.x.x)</option>
                                            <option value="6">Legion (7.x.x)</option>
                                            <option value="5">Warlords of Draenor (6.x.x)</option>
                                            <option value="4">Mists of Pandaria 5.x.x)</option>
                                            <option value="3">Cataclysm (4.3.4)</option>
                                            <option value="2">Wrath of the Lich King (3.3.5)</option>
                                            <option value="1">The Burning Crusade (2.4.3)</option>
                                            <option value="0">Vanilla / No Expansion (1.12.1)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="keywords">Search engine: keywords (recommended for a better SEO Ranking)(separated by comma)</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" id="keywords" name="keywords" placeholder="world of warcraft,wow,private server,pvp">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="description">Search engine: description (recommended for a better SEO Ranking)</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" id="description" name="description" placeholder="Best World of Warcraft private server in the entire world!">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="analytics"><a href="https://analytics.google.com/analytics/web/" target="_blank">Google Analytics</a> website ID (optional)</label>
                                    <div class="col-md-9">
                                        <small class="text-muted d-block mb-1">(A more in-depth Analytic System than what is provided within the Admin Panel [ACP])</small>
                                        <input class="form-control" type="text" id="analytics" name="analytics" placeholder="XX-YYYYYYYY-Z">
                                    </div>
                                </div>
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <span class="loader d-none"><i class="fa fa-spinner fa-spin me-1"></i> Please wait...</span>
                                        <span class="button-text"><i class='fa fa-chevron-right'></i> Next</span> 
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="database-tab">
                            <form name="database-form" id="database-form" action="do_database.php" method="post" autocomplete="off">
                                <h6>1. Please enter your <strong>FusionGEN</strong> database connection details.</h6>
                                <hr>
                                <div class="row mb-3">
                                    <label for="host" class="col-md-3 col-form-label">Database Host</label>
                                    <div class="col-md-9">
                                        <input type="text" id="host" name="host" class="form-control" placeholder="FusionGEN Database Host (usually localhost)">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="dbuser" class="col-md-3 col-form-label">Database User</label>
                                    <div class="col-md-9">
                                        <input type="text" name="dbuser" class="form-control" placeholder="FusionGEN Database user name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="dbpassword" class="col-md-3 col-form-label">Database Password</label>
                                    <div class="col-md-9">
                                        <input type="password" name="dbpassword" class="form-control" placeholder="FusionGEN Database user password">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="dbname" class="col-md-3 col-form-label">Database Name</label>
                                    <div class="col-md-9">
                                        <input type="text" name="dbname" class="form-control" placeholder="FusionGEN Database Name">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="dbport" class="col-md-3 col-form-label">Database Port</label>
                                    <div class="col-md-9">
                                        <input type="number" name="dbport" class="form-control" placeholder="FusionGEN Database Port">
                                    </div>
                                </div>

                                <h6>2. Please enter your <strong>Auth</strong> database connection details.</h6>
                                <hr>
                                <div class="row mb-3">
                                    <label for="auth_host" class="col-md-3 col-form-label">Database Host</label>
                                    <div class="col-md-9">
                                        <input type="text" id="auth_host" name="auth_host" class="form-control" placeholder="Auth Database Host (usually localhost)">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="auth_db_user" class="col-md-3 col-form-label">Database User</label>
                                    <div class="col-md-9">
                                        <input type="text" name="auth_db_user" class="form-control" placeholder="Auth Database user name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="auth_db_pass" class="col-md-3 col-form-label">Database Password</label>
                                    <div class="col-md-9">
                                        <input type="password" name="auth_db_pass" class="form-control" placeholder="Auth Database user password">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="auth_db" class="col-md-3 col-form-label">Database Name</label>
                                    <div class="col-md-9">
                                        <input type="text" name="auth_db" class="form-control" placeholder="Auth Database Name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="auth_port" class="col-md-3 col-form-label">Database Port</label>
                                    <div class="col-md-9">
                                        <input type="number" name="auth_port" class="form-control" placeholder="Auth Database Port">
                                    </div>
                                </div>

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <span class="loader d-none"><i class="fa fa-spinner fa-spin me-1"></i> Please wait...</span>
                                        <span class="button-text"><i class='fa fa-chevron-right'></i> Next</span> 
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="realms-tab">
                            <form name="realms-form" id="realms-form" action="do_realms.php" method="post" autocomplete="off">
                                <h6>Realms settings</h6>
                                <hr>
                                <p class="small text-muted">You must specify a realm so that you can log in later. If you host the realm databases on another host, you can configure that via the admin panel afterwards.</p>
                                
                                <div class="row mb-3">
                                    <label for="hostname" class="col-md-3 col-form-label">Hostname</label>
                                    <div class="col-md-9"><input class="form-control" type="text" id="hostname" name="hostname" placeholder="127.0.0.1"></div>
                                </div>
                                <div class="row mb-3">
                                    <label for="username" class="col-md-3 col-form-label">Database username</label>
                                    <div class="col-md-9"><input class="form-control" type="text" id="username" name="username" placeholder="Realm Database username"></div>
                                </div>
                                <div class="row mb-3">
                                    <label for="password" class="col-md-3 col-form-label">Database password</label>
                                    <div class="col-md-9"><input class="form-control" type="password" id="password" name="password" placeholder="Realm Database password"></div>
                                </div>
                                <div class="row mb-3">
                                    <label for="characters" class="col-md-3 col-form-label">Characters database</label>
                                    <div class="col-md-9"><input class="form-control" type="text" id="characters" name="characters" placeholder="Characters database name"></div>
                                </div>
                                <div class="row mb-3">
                                    <label for="world" class="col-md-3 col-form-label">World database</label>
                                    <div class="col-md-9"><input class="form-control" type="text" id="world" name="world" placeholder="World database name"></div>
                                </div>
                                <div class="row mb-3">
                                    <label for="cap" class="col-md-3 col-form-label">Max allowed players online</label>
                                    <div class="col-md-9"><input class="form-control" type="number" id="cap" name="cap" placeholder="100"></div>
                                </div>
                                <div class="row mb-3">
                                    <label for="realmName" class="col-md-3 col-form-label">Realm name</label>
                                    <div class="col-md-9"><input class="form-control" type="text" id="realmName" name="realmName" placeholder="Realm name"></div>
                                </div>
                                <div class="row mb-3">
                                    <label for="db_port" class="col-md-3 col-form-label">Database port</label>
                                    <div class="col-md-9"><input class="form-control" type="number" id="db_port" name="db_port" placeholder="3306"></div>
                                </div>
                                <div class="row mb-3">
                                    <label for="console_username" class="col-md-3 col-form-label" data-toggle="tooltip" data-placement="top" title="For an ingame account with GM level high enough to connect to your emulator console remotely (see your emulator's config files for more details)">Console username (only required for emulators that use remote console systems) (?)</label>
                                    <div class="col-md-9"><input class="form-control" type="text" id="console_username" name="console_username" placeholder="Username from GM LvL 4 Account"></div>
                                </div>
                                <div class="row mb-3">
                                    <label for="console_password" class="col-md-3 col-form-label" data-toggle="tooltip" data-placement="top" title="For an ingame account with GM level high enough to connect to your emulator console remotely (see your emulator's config files for more details)">Console password (only required for emulators that use remote console systems) (?)</label>
                                    <div class="col-md-9"><input class="form-control" type="password" id="console_password" name="console_password" placeholder="Password from GM LvL 4 Account"></div>
                                </div>
                                <div class="row mb-3">
                                    <label for="console_port" class="col-md-3 col-form-label">Console port</label>
                                    <div class="col-md-9"><input class="form-control" type="number" id="console_port" name="console_port" placeholder="7878 suggested"></div>
                                </div>
                                <div class="row mb-3">
                                    <label for="emulator" class="col-md-3 col-form-label">Emulator</label>
                                    <div class="col-md-9">
                                        <select class="form-select" id="emulator" name="emulator">
                                            <option value="" disabled="disabled">Loading...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="realm_port" class="col-md-3 col-form-label">Realm port</label>
                                    <div class="col-md-9"><input class="form-control" type="number" id="realm_port" name="realm_port" placeholder="8085"></div>
                                </div>

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <span class="loader d-none"><i class="fa fa-spinner fa-spin me-1"></i> Please wait...</span>
                                        <span class="button-text"><i class='fa fa-chevron-right'></i> Next</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="owner-tab">
                            <form name="owner-form" id="owner-form" action="do_owner.php" method="post" autocomplete="off">
                                <h6>Homepage Owner</h6>
                                <hr>
                                <p>Enter your account name to get owner access on the homepage (Case sensitive!)</p>
                                <div class="row mb-3">
                                    <label for="accname" class="col-md-3 col-form-label">Account Name</label>
                                    <div class="col-md-9"><input class="form-control" type="text" id="accname" name="accname"></div>
                                </div>
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <span class="loader d-none"><i class="fa fa-spinner fa-spin me-1"></i> Please wait...</span>
                                        <span class="button-text"><i class='fa fa-chevron-right'></i> Complete Installation</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="finished-tab">
                            <div class="text-center py-5">
                                <i class="fa fa-check-circle text-success mb-3" style="font-size: 80px;"></i>
                                <h4>Congratulation!</h4>
                                <p>You have successfully installed FusionGEN!</p>
                                <div class="alert alert-warning d-inline-block mt-3">
                                    Don't forget to delete "install" folder!
                                </div>
                                <div class="mt-5">
                                    <a class="btn btn-outline-primary btn-lg px-5" href="<?php echo $dashboard_url; ?>">
                                        <i class="fa fa-desktop me-2"></i> GO TO YOUR HOMEPAGE
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    // ─── Dark Mode Toggle ────────────────────────────────────────────────────────
    document.getElementById('darkModeToggle').addEventListener('click', function () {
        const html = document.documentElement;
        const isDark = html.getAttribute('data-bs-theme') === 'dark';
        html.setAttribute('data-bs-theme', isDark ? 'light' : 'dark');
        this.innerHTML = isDark ? '<i class="fa fa-sun-o"></i>' : '<i class="fa fa-moon-o"></i>';
    });

    // ─── Button Loading State Helpers ────────────────────────────────────────────
    /**
     * setButtonLoading(btn, isLoading)
     * Toggles the spinner/text visibility and disabled state on a submit button.
     * Works for both jQuery objects and native elements.
     */
    function setButtonLoading($btn, isLoading) {
        $btn.prop('disabled', isLoading)
            .find('.loader').toggleClass('d-none', !isLoading).end()
            .find('.button-text').toggleClass('d-none', isLoading);
    }

    // ─── jQuery Document Ready ───────────────────────────────────────────────────
    $(function () {

        // Step order used for both non-ajax and ajax navigation
        const STEP_FLOW = ['introduction', 'requirements', 'general', 'database', 'realms', 'owner', 'finished'];

        /**
         * switchTab(currentId, nextId)
         * Marks the current nav pill as complete, activates the next one,
         * swaps visible tab pane, focuses first input, and scrolls to the card.
         */
        function switchTab(currentId, nextId) {
            $(`#${currentId}`)
                .removeClass('active')
                .addClass('text-success')
                .find('i').removeClass('fa-circle-o').addClass('fa-check-circle');

            $(`#${nextId}`).addClass('active');

            $('.tab-pane').removeClass('show active');
            $(`#${nextId}-tab`).addClass('show active').find('input').first().focus();

            $('html, body').animate({ scrollTop: $('.card').offset().top - 20 }, 'fast');
        }

        // ── Non-ajax "Next" buttons (Introduction → Requirements → General) ──────
        $('.form-next').on('click', function () {
            const activePane = $('.tab-pane.active').attr('id').replace('-tab', '');
            const nextIndex  = STEP_FLOW.indexOf(activePane) + 1;
            if (nextIndex > 0 && nextIndex < STEP_FLOW.length) {
                switchTab(activePane, STEP_FLOW[nextIndex]);
            }
        });

        // ── AJAX form submissions ─────────────────────────────────────────────────
        const NEXT_STEP_MAP = { general: 'database', database: 'realms', realms: 'owner', owner: 'finished' };

        $('#general-form, #database-form, #realms-form, #owner-form').on('submit', function (e) {
            e.preventDefault();
            const $form  = $(this);
            const formId = $form.attr('id').replace('-form', '');
            const $btn   = $form.find('[type="submit"]');

            $('#alert-container').empty();
            setButtonLoading($btn, true);

            $form.ajaxSubmit({
                dataType: 'json',
                success: function (result) {
                    setButtonLoading($btn, false);

                    if (result.success) {
                        switchTab(formId, NEXT_STEP_MAP[formId]);

                        if (formId === 'database' && typeof Ajax !== 'undefined') {
                            Ajax.initialize();
                        }
                        if (formId === 'owner') {
                            $('input, select, textarea').unpersist();
                        }
                    } else {
                        $('#alert-container').html('<div class="alert alert-danger shadow-sm">' + result.message + '</div>');
                        $('html, body').animate({ scrollTop: $('#alert-container').offset().top - 100 }, 'fast');
                    }
                }
            });
        });

        // ── Persist form inputs across page refreshes ─────────────────────────────
        if ($.fn.persist) {
            $('input, select, textarea').persist();
        }
    });
</script>
    </body>
</html>
