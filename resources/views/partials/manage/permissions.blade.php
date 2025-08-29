<?php session_start(); ?>
<?php include "header.php"?>
<script>
    function aidselect(a) {
    var x = a.options[a.selectedIndex].value;
    location.replace("permissions.php?aid="+x);
    }
</script>
<?php
$aid = "";
$selected_aid = "";

// 處理表單提交（更新權限）
if (isset($_POST['aid']) && isset($_POST['sid'])) {
    $aid = $_POST['aid'];
    $sid_array = $_POST['sid'];

    // 先刪除該管理者的所有權限
    $delete_sql = "DELETE FROM mright WHERE account = :account";
    $delete_stmt = $link->prepare($delete_sql);
    $delete_stmt->bindParam(':account', $aid);
    $delete_stmt->execute();

    // 重新插入選中的權限
    if (!empty($sid_array)) {
        $insert_sql = "INSERT INTO mright (account, sid) VALUES (:account, :sid)";
        $insert_stmt = $link->prepare($insert_sql);

        foreach ($sid_array as $sid) {
            $insert_stmt->bindParam(':account', $aid);
            $insert_stmt->bindParam(':sid', $sid);
            $insert_stmt->execute();
        }
    }

    echo "<script>alert('權限更新成功！');</script>";
}

// 處理GET請求（選擇管理者）
if (isset($_GET['aid'])) {
    $selected_aid = $_GET['aid'];
}
?>

                    <div class="col-lg-12">
                        <div class="card alert">
                            <div class="card-header">
                                <h2>權限管理</h2><Br/>
                                 <div class="row">

                                </div>
                            </div>
                            
                            <div class="card-body">
                                <div class="horizontal-form">
                                    <form class="form-horizontal" method="post" action="permissions.php">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">管理者帳號：</label>
                                            <div class="col-sm-10">
                                                <?php
                                                include '../Connections/conn_db.php';
                                                // 修正：使用正確的連接變數和欄位名稱
                                                $sql = "SELECT admin.account, admin.password, username.username
                                                        FROM admin
                                                        LEFT JOIN username ON admin.account = username.account
                                                        ORDER BY admin.account ASC";
                                                $result = $link->query($sql);
                                                ?>
                                                <select size="1" name="aid" class="form-control" onchange="aidselect(this)" >
                                                <option value="">請選擇管理者</option>
                                                <?php
                                                while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                                                    $display_name = !empty($row['username']) ? $row['username'] : $row['account'];
                                                    $selected = ($selected_aid == $row['account']) ? 'selected' : '';
                                                    echo "<option value=\"".$row['account']."\" $selected>".$row['account']." (".$display_name.")</option>";
                                                }
                                                ?>
                                               </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">權限：</label>
                                            <div class="col-sm-10">
                                                <?php
                                                // 獲取所有可用的程式權限
                                                $programs_sql = "SELECT * FROM programs ORDER BY sid ASC";
                                                $programs_result = $link->query($programs_sql);

                                                // 如果選擇了管理者，獲取其現有權限
                                                $user_permissions = array();
                                                if (!empty($selected_aid)) {
                                                    $perm_sql = "SELECT sid FROM mright WHERE account = :account";
                                                    $perm_stmt = $link->prepare($perm_sql);
                                                    $perm_stmt->bindParam(':account', $selected_aid);
                                                    $perm_stmt->execute();
                                                    while ($perm_row = $perm_stmt->fetch(PDO::FETCH_ASSOC)) {
                                                        $user_permissions[] = $perm_row['sid'];
                                                    }
                                                }

                                                // 顯示權限複選框
                                                while ($prog_row = $programs_result->fetch(PDO::FETCH_ASSOC)) {
                                                    $checked = in_array($prog_row['sid'], $user_permissions) ? 'checked' : '';
                                                    $disabled = empty($selected_aid) ? 'disabled' : '';
                                                    echo '<div class="checkbox">';
                                                    echo '<label>';
                                                    echo '<input type="checkbox" name="sid[]" value="'.$prog_row['sid'].'" '.$checked.' '.$disabled.'>';
                                                    echo ' '.$prog_row['sid'].' - '.$prog_row['sname'];
                                                    echo '</label>';
                                                    echo '</div>';
                                                }

                                                if (empty($selected_aid)) {
                                                    echo '<p class="text-muted">請先選擇管理者以設定權限</p>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-primary" <?php echo empty($selected_aid) ? 'disabled' : ''; ?>>
                                                    <i class="ti-check"></i> 確認更新權限
                                                </button>
                                                <a href="index.php" class="btn btn-secondary ms-2">
                                                    <i class="ti-close"></i> 離開
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                     </div><!-- /# column -->					

						
 <?php include "footer.php"?>