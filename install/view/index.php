<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Err0r">
        <link rel="icon" href="assets/images/favicon.png">
        <title>安装 - FusionGEN</title>
        <link rel='stylesheet' type='text/css' href='assets/bootstrap/css/bootstrap.min.css'>
        <link rel='stylesheet' type='text/css' href='assets/css/font-awesome/css/font-awesome.min.css'>
        <link rel='stylesheet' type='text/css' href='assets/css/install.css'>
        <script type='text/javascript' src="assets/js/realms.js"></script>
        <script type='text/javascript' src='assets/js/jquery-1.11.3.min.js'></script>
        <script type='text/javascript' src='assets/js/jquery-validation/jquery.validate.min.js'></script>
        <script type='text/javascript' src='assets/js/jquery-validation/jquery.form.js'></script>
        <script type='text/javascript' src='assets/js/jquery-persist.js'></script>
    </head>
    <body>
        <div class="install-box">
            <div class="panel panel-install">
                <div class="panel-heading text-center">                    
					<img src="assets/images/logo.png">
                </div>
                <div class="panel-body no-padding">
                    <div class="tab-container clearfix">
					<div id="introduction" class="tab-title col-sm-3 active"><i class="fa fa-circle-o"></i><strong> 简介</strong></div>
                        <div id="requirements" class="tab-title col-sm-3"><i class="fa fa-circle-o"></i><strong> 系统要求</strong></span></div>
						<div id="general" class="tab-title col-sm-3"><i class="fa fa-circle-o"></i><strong> 常规设置</strong></div>
                        <div id="database" class="tab-title col-sm-3"><i class="fa fa-circle-o"></i><strong> 数据库</strong></div>
						<div id="realms" class="tab-title col-sm-3"><i class="fa fa-circle-o"></i><strong> 游戏服务器</strong></div>
                        <div id="finished" class="tab-title col-sm-3"><i class="fa fa-circle-o"></i><strong> 完成</strong></div> 
                    </div>
                    <div id="alert-container"></div>

                    <div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="introduction-tab">
							<div class="section clearfix">
								<div>
									<div class="introduction">
										<center><h3>欢迎使用 FusionGEN</h3></center>
										<center><b>亲爱的用户</b>，这是 <b>FusionGEN</b>。</br>在开源的条件下，由其他网页开发者继续的一个项目。许多人喜欢 FusionCMS，但是时间在变化，FusionCMS 已经停滞了一段时间。我们在这里推出一个新的开源项目，为 <b>您</b> 提供一个优化和关怀的内容管理系统（CMS），并且将随着时间的推移与贡献者的热爱和热情不断发展。FusionGEN 仍然由 Codeigniter 框架驱动，拥有其原始的 PHP 代码、HTML 代码和 JavaScript 代码。我们的重点是改进所有内容，使其更强大、更快速和更现代化。</br></br>感谢您下载 FusionGEN</br>祝您使用愉快！</center> 
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<button type="submit" class="btn btn-info form-next">
									<span class="loader hide"> 请稍等...</span>
									<span class="button-text"><i class='fa fa-chevron-right'></i> 开始安装程序</span> 
								</button>
							</div>
						</div>
                        <div role="tabpanel" class="tab-pane" id="requirements-tab">
                            <div class="section">
                                <p>1. 请配置您的 PHP 设置以满足以下要求：</p>
                                <hr>
                                <div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th width="25%">PHP 设置</th>
                                                <th width="27%">当前版本</th>
                                                <th>最低版本</th>
                                                <th class="text-center">状态</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>PHP 版本</td>
                                                <td><?php echo $current_php_version; ?></td>
                                                <td><?php echo $php_version_min; ?></td>
                                                <td class="text-center">
                                                    <?php if ($php_version_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="section">
                                <p>2. 请确保以下列出的扩展和设置已安装/启用：</p>
                                <hr>
                                <div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th width="25%">扩展/设置</th>
                                                <th width="27%">当前设置</th>
                                                <th>所需设置</th>
                                                <th class="text-center">状态</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>MySQLi</td>
                                                <td> <?php if ($mysql_success) { ?>
                                                        已启用
                                                    <?php } else { ?>
                                                        未启用
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($mysql_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>GD</td>
                                                <td> <?php if ($gd_success) { ?>
                                                        已启用
                                                    <?php } else { ?>
                                                        未启用
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($gd_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>cURL</td>
                                                <td> <?php if ($curl_success) { ?>
                                                        已启用
                                                    <?php } else { ?>
                                                        未启用
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($curl_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
											<tr>
                                                <td>json</td>
                                                <td> <?php if ($json_success) { ?>
                                                        已启用
                                                    <?php } else { ?>
                                                        未启用
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($json_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
											<tr>
                                                <td>GMP</td>
                                                <td> <?php if ($gmp_success) { ?>
                                                        已启用
                                                    <?php } else { ?>
                                                        未启用
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($gmp_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
											<tr>
                                                <td>SOAP</td>
                                                <td> <?php if ($soap_success) { ?>
                                                        已启用
                                                    <?php } else { ?>
                                                        未启用
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($soap_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
											<tr>
                                                <td>MBString</td>
                                                <td> <?php if ($mbstring_success) { ?>
                                                        已启用
                                                    <?php } else { ?>
                                                        未启用
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($mbstring_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>OpenSSL</td>
                                                <td> <?php if ($openssl_success) { ?>
                                                        已启用
                                                    <?php } else { ?>
                                                        未启用
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($openssl_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Zip</td>
                                                <td> <?php if ($zip_success) { ?>
                                                        已启用
                                                    <?php } else { ?>
                                                        未启用
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($zip_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>XML</td>
                                                <td> <?php if ($xml_success) { ?>
                                                        已启用
                                                    <?php } else { ?>
                                                        未启用
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($xml_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>

							<!--<div class="section">
                                <p>3. 请确保已安装/启用以下模块：</p>
                                <hr>
                                <div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th width="25%">模块/设置</th>
                                                <th width="27%">当前设置</th>
                                                <th>所需设置</th>
                                                <th class="text-center">状态</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Rewrite</td>
                                                <td> <?php if ($rewrite_success) { ?>
                                                        已启用
                                                    <?php } else { ?>
                                                        未启用
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($rewrite_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>-->

                            <div class="section">
                                <p>3. 请确保您已对以下文件夹/文件设置了<strong>可写</strong>权限：</p>
                                <hr>
                                <div>
                                    <table>
                                        <tbody>
                                            <?php
                                            foreach ($writeable_directories as $value) {
                                                ?>
                                                <tr>
                                                    <td style="width:87%;"><?php echo $value; ?></td>  
                                                    <td class="text-center">
                                                        <?php if (is_writeable(".." . $value)) { ?>
                                                            <i class="status fa fa-check-circle-o"></i>
                                                            <?php
                                                        } else {
                                                            $all_requirement_success = false;
                                                            ?>
                                                            <i class="status fa fa-times-circle-o"></i>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="panel-footer">
                                <button <?php
                                if (!$all_requirement_success) {
                                    echo "disabled=disabled";
                                }
                                ?> class="btn btn-info form-next"><i class='fa fa-chevron-right'></i> 下一步</button>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="general-tab">
							<form name="general-form" id="general-form" action="do_general.php" method="post" autocomplete="off">
								<div class="section clearfix">
									<p>填写常规设置</p>
									<hr>
									<div>
										<div class="form-group clearfix">
											<label class="col-md-3" for="title">网站名称</label>
											<div class="col-md-9">
												<input class="form-control" type="text" value="" id="title" name="title" placeholder="我的网站名称">
											</div>
										</div>
										<div class="form-group clearfix">
											<label class="col-md-3" for="server_name">服务器名称</label>
											<div class="col-md-9">
												<input class="form-control" type="text" value="" id="server_name" name="server_name" placeholder="我的服务器名称">
											</div>
										</div>
										<div class="form-group clearfix">
											<label class="col-md-3" for="realmlist">服务器地址</label>
											<div class="col-md-9">
												<input class="form-control" type="text" value="" id="realmlist" name="realmlist" placeholder="logon.tbcstar.com">
											</div>
										</div>
										<div class="form-group clearfix">
											<label class=" col-md-3" for="security_code">管理员面板（ACP）安全密码</label>
											<div class="col-md-9">
												<input class="form-control" type="text" value="" id="security_code" name="security_code">
											</div>
										</div>
										<div class="form-group clearfix">
											<label class="col-md-3" for="max_expansion">最大资料片版本</label>
											<div class="col-md-9">
												<select class="form-control" id="max_expansion" name="max_expansion">
													<option value="9">巨龙之风 (10.x.x)</option>
													<option value="8">暗影国度 (9.x.x)</option>
													<option value="7">争霸艾泽拉斯 (8.x.x)</option>
													<option value="6">军团再临 (7.x.x)</option>
													<option value="5">德拉诺之王 (6.x.x)</option>
													<option value="4">熊猫人之谜 (5.x.x)</option>
													<option value="3">大地的裂变 (4.3.4)</option>
													<option value="2">巫妖王之怒 (3.3.5)</option>
													<option value="1">燃烧的远征 (2.4.3)</option>
													<option value="0">经典 / 无扩展 (1.12.1)</option>
												</select>
											</div>
										</div>
										<div class="form-group clearfix">
											<label class="col-md-3" for="keywords">搜索引擎关键词（推荐以逗号分隔，用于更好的SEO排名）</label>
											<div class="col-md-9">
												<input class="form-control" type="text" value="" id="keywords" name="keywords" placeholder="world of warcraft,wow,pvp,魔兽世界,wow,私服,pvp">
											</div>
										</div>
										<div class="form-group clearfix">
											<label class="col-md-3" for="description">搜索引擎描述（推荐以提高SEO排名）</label>
											<div class="col-md-9">
												<input class="form-control" type="text" value="" id="description" name="description" placeholder="全球最佳魔兽世界私服！">
											</div>
										</div>
										<div class="form-group clearfix">
											<label class=" col-md-3" for="analytics"><a href="https://analytics.google.com/analytics/web/" target="_blank">Google Analytics</a> 网站ID（可选，用于高级统计）</label>
											<div class="col-md-9">
											（比管理面板[ACP]内提供的统计系统更深入的分析系统）
												<input class="form-control" type="text" value="" id="analytics" name="analytics" placeholder="XX-YYYYYYYY-Z">
											</div>
										</div>
									</div>
								</div>

								<div class="panel-footer">
									<button type="submit" class="btn btn-info form-next">
										<span class="loader hide"> 请稍候...</span>
										<span class="button-text"><i class='fa fa-chevron-right'></i> 下一步</span> 
									</button>
								</div>
							</form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="database-tab">
                            <form name="database-form" id="database-form" action="do_database.php" method="post" autocomplete="off">
                                <div class="section clearfix">
                                    <p>1. 请输入您的 <strong>网站</strong> 数据库连接详细信息。</p>
                                    <hr>
                                    <div>
                                        <div class="form-group clearfix">
                                            <label for="host" class="col-md-3">数据库主机</label>
                                            <div class="col-md-9">
                                                <input type="text" value="" id="host" name="host" class="form-control" placeholder="网站数据库主机（通常为localhost）">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="dbuser" class="col-md-3">数据库用户</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="dbuser" class="form-control" autocomplete="off" placeholder="网站数据库用户名">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="dbpassword" class="col-md-3">密码</label>
                                            <div class=" col-md-9">
                                                <input type="password" value="" name="dbpassword" class="form-control" autocomplete="off" placeholder="网站数据库用户密码">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="dbname" class="col-md-3">数据库名称</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="dbname" class="form-control" placeholder="网站数据库名称">
                                            </div>
                                        </div>
										<div class="form-group clearfix">
                                            <label for="dbname" class="col-md-3">数据库端口</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="dbport" class="form-control" placeholder="网站数据库端口">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section clearfix">
                                    <p>2. 请输入您的 <strong>Auth</strong> 数据库连接详细信息。</p>
                                    <hr>
                                    <div>
                                        <div class="form-group clearfix">
                                            <label for="auth_host" class="col-md-3">数据库主机</label>
                                            <div class="col-md-9">
                                                <input type="text" value="" id="auth_host"  name="auth_host" class="form-control" placeholder="Auth数据库主机（通常为localhost）">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="auth_db_user" class="col-md-3">数据库用户</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="auth_db_user" class="form-control" autocomplete="off" placeholder="Auth数据库用户名">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="auth_db_pass" class="col-md-3">密码</label>
                                            <div class=" col-md-9">
                                                <input type="password" value="" name="auth_db_pass" class="form-control" autocomplete="off" placeholder="Auth数据库用户密码">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="auth_db" class="col-md-3">数据库名称</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="auth_db" class="form-control" placeholder="Auth数据库名称">
                                            </div>
                                        </div>
										<div class="form-group clearfix">
                                            <label for="auth_db" class="col-md-3">数据库端口</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="auth_port" class="form-control" placeholder="Auth数据库端口">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-footer">
                                    <button type="submit" class="btn btn-info form-next">
                                        <span class="loader hide"> 请稍候...</span>
                                        <span class="button-text"><i class='fa fa-chevron-right'></i> 完成</span> 
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="realms-tab">
							<form name="realms-form" id="realms-form" action="do_realms.php" method="post" autocomplete="off">
								<div class="section clearfix">
									<p>游戏服务器设置</p>
									<hr>
									<span>您必须指定一个游戏服务器以便以后登录</span><br>
									<span>如果您将游戏服务器数据库托管在另一台主机上（即不在您运行模拟器的服务器上），您可以稍后通过管理面板进行配置</span>
									<div>
										<div class="form-group clearfix">
											<label for="hostname" class="col-md-3">主机名</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="hostname" name="hostname" placeholder="127.0.0.1">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="username" class="col-md-3">数据库用户名</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="username" name="username" placeholder="游戏服务器数据库用户名">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="password" class="col-md-3">数据库密码</label>
											<div class=" col-md-9">
												<input class="form-control" type="password" value="" id="password" name="password" placeholder="游戏服务器数据库密码">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="characters" class="col-md-3">角色数据库</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="characters" name="characters" placeholder="角色数据库名称">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="world" class="col-md-3">世界数据库</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="world" name="world" placeholder="世界数据库名称">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="cap" class="col-md-3">最大在线玩家数量</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="cap" name="cap" placeholder="99999">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="realmName" class="col-md-3">服务器名称</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="realmName" name="realmName" placeholder="服务器名称">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="db_port" class="col-md-3">数据库端口</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="db_port" name="db_port" placeholder="3306">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="console_username" class="col-md-3" data-toggle="tooltip" data-placement="top" title="只适用于使用远程控制台系统的模拟器，需要具有足够高权限的游戏内账号才能远程连接到控制台（详细信息请参阅模拟器的配置文件）">控制台用户名（仅适用于使用远程控制台系统的模拟器）(?)</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="console_username" name="console_username" placeholder="GM LvL 4账号的用户名">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="console_password" class="col-md-3" data-toggle="tooltip" data-placement="top" title="只适用于使用远程控制台系统的模拟器，需要具有足够高权限的游戏内账号才能远程连接到控制台（详细信息请参阅模拟器的配置文件）">控制台密码（仅适用于使用远程控制台系统的模拟器）(?)</label>
											<div class=" col-md-9">
												<input class="form-control" type="password" value="" id="console_password" name="console_password" placeholder="GM LvL 4账号的密码">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="console_port" class="col-md-3">控制台端口（仅适用于使用远程控制台系统的模拟器；通常为3443（RA）或7878（SOAP））</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="console_port" name="console_port" placeholder="建议7878">
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="emulator" class="col-md-3">模拟器</label>
											<div class=" col-md-9">
											<select class="form-control" id="emulator" name="emulator">
												<option  value="" class="form-control" disabled="disabled">加载中...</option>
											</select>
											</div>
										</div>

										<div class="form-group clearfix">
											<label for="realm_port" class="col-md-3">服务器端口（通常为Trinity/AzerothCore等基于的模拟器的8085）</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="realm_port" name="realm_port" placeholder="8085">
											</div>
										</div>
									</div>
								</div>

								<div class="panel-footer">
									<button type="submit" class="btn btn-info form-next">
										<span class="loader hide"> 请稍候...</span>
										<span class="button-text"><i class='fa fa-chevron-right'></i> 下一步</span> 
									</button>
								</div>
							</form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="owner-tab">
							<form name="owner-form" id="owner-form" action="do_owner.php" method="post" autocomplete="off">
								<div class="section clearfix">
									<p>主页所有者</p>
									<hr>
									<span>输入您的账户名以获取主页所有者访问权限（区分大小写！）</span>
									<div>
										<div class="form-group clearfix">
											<label for="accname" class="col-md-3">账户名</label>
											<div class=" col-md-9">
												<input class="form-control" type="text" value="" id="accname" name="accname" placeholder="">
											</div>
										</div>
									</div>
								</div>

								<div class="panel-footer">
									<button type="submit" class="btn btn-info form-next">
										<span class="loader hide"> 请稍候...</span>
										<span class="button-text"><i class='fa fa-chevron-right'></i> 完成安装</span> 
									</button>
								</div>
							</form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="finished-tab">
                            <div class="section">
                                <div class="clearfix">
                                    <i class="status fa fa-check-circle-o pull-left" style="font-size: 50px"> </i><span class="pull-left"  style="line-height: 50px;">恭喜！您已成功安装 FusionGen！</span>  
                                </div>

                                <div style="margin: 15px 0 15px 60px; color: #d73b3b;">
                                    不要忘记删除 "install" 文件夹！
                                </div>

								<a class="go-to-login-page" href="<?php echo $dashboard_url; ?>">
                                    <div class="text-center">
                                        <div style="font-size: 100px;"><i class="fa fa-desktop"></i></div>
                                        <div>前往您的主页</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">

    var onFormSubmit = function ($form) {
        $form.find('[type="submit"]').attr('disabled', 'disabled').find(".loader").removeClass("hide");
        $form.find('[type="submit"]').find(".button-text").addClass("hide");
        $("#alert-container").html("");
    };
    var onSubmitSussess = function ($form) {
        $form.find('[type="submit"]').removeAttr('disabled').find(".loader").addClass("hide");
        $form.find('[type="submit"]').find(".button-text").removeClass("hide");
    };

    $(document).ready(function () {
        var $introductionTab = $("#introduction-tab"),
            $requirementsTab = $("#requirements-tab"),
            $generalTab = $("#general-tab"),
            $databaseTab = $("#database-tab"),
            $realmsTab = $("#realms-tab"),
            $ownerTab = $("#owner-tab");

        $(".form-next").click(function () {
			if ($requirementsTab.hasClass("active")) {
                $requirementsTab.removeClass("active");
                $generalTab.addClass("active");
                $("#requirements").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                $("#general").addClass("active");
                $("#title").focus();
            }
			if ($introductionTab.hasClass("active")) {
                $introductionTab.removeClass("active");
                $requirementsTab.addClass("active");
                $("#introduction").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                $("#requirements").addClass("active");
            }
        });

		$("#general-form").submit(function () {
            var $form = $(this);
            onFormSubmit($form);
            $form.ajaxSubmit({
                dataType: "json",
                success: function (result) {
                    onSubmitSussess($form, result);
                    if (result.success) {
                        $generalTab.removeClass("active");
                        $("#general").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                        $("#database").addClass("active");
                        $("#database-tab").addClass("active");
                        $("#host").focus();
                    } else {
						$("#alert-container").html('<div class="alert alert-danger" role="alert">' + result.message + '</div>');
                    }
                }
            });
            return false;
        });

        $("#database-form").submit(function () {
            var $form = $(this);
            onFormSubmit($form);
            $form.ajaxSubmit({
                dataType: "json",
                success: function (result) {
                    onSubmitSussess($form, result);
                    if (result.success) {
                        $databaseTab.removeClass("active");
                        $("#database").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                        $("#realms").addClass("active");
                        $("#realms-tab").addClass("active");
                        Ajax.initialize();
                        $("#hostname").focus();
                    } else {
                        $("#alert-container").html('<div class="alert alert-danger" role="alert">' + result.message + '</div>');
                    }
                }
            });
            return false;
        });

        $("#realms-form").submit(function () {
            var $form = $(this);
            onFormSubmit($form);
            $form.ajaxSubmit({
                dataType: "json",
                success: function (result) {
                    onSubmitSussess($form, result);
                    if (result.success) {
                        $realmsTab.removeClass("active");
                        $("#realms").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                        $("#finished").addClass("active");
                        $("#owner-tab").addClass("active");
                        $("#accname").focus();
                    } else {
                        $("#alert-container").html('<div class="alert alert-danger" role="alert">' + result.message + '</div>');
                    }
                }
            });
            return false;
        });
        $("#owner-form").submit(function () {
            var $form = $(this);
            onFormSubmit($form);
            $form.ajaxSubmit({
                dataType: "json",
                success: function (result) {
                    onSubmitSussess($form, result);
                    if (result.success) {
                        $ownerTab.removeClass("active");
                        $("#finished").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                        $("#finished").addClass("active");
                        $("#finished-tab").addClass("active");
						$('input,select,textarea').unpersist();
                    } else {
                        $("#alert-container").html('<div class="alert alert-danger" role="alert">' + result.message + '</div>');
                    }
                }
            });
            return false;
        });

    });
</script>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('input,select,textarea').persist();
	});
</script>

<style>
.swal2-popup {
  font-size: 1.6rem !important;
}
</style>