<div class="sidebar">
    <div class="profile">
        <h3>Leave Pro <span style="font-size:1.6rem;font-style:bold;">&#128293;</span></h3>
    </div>
    <ul style="margin-bottom: 30px;">
        <li>
            <a href="index.php" class="active">
                <span class="item-main"><span style="font-size:20px;margin-right:5px;">&#127968;</span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="add-employee.php">
                <span class="item-main"><span style="font-size:20px;margin-right:5px;">&#128102;</span>Employees</span>
            </a>
        </li>
        <?php            
            if($_SESSION["role"] == "superadmin"){ ?>
            <li>
                <a href="add-admin.php">
                    <span class="item-main"><span style="font-size:20px;margin-right:5px;">&#128104;</span>Admin</span>
                </a>
            </li>
        <?php }
            else{ ?>

        <?php } ?>
        <li>
            <a href="add-leave-types.php">
                <span class="item-main"><span style="font-size:20px;margin-right:5px;">&#9780;</span>Leave Types</span>
            </a>
        </li>
        <li>
            <a href="leaves.php">
                <span class="item-main"><span style="font-size:20px;margin-right:5px;">&#x1F4C5;</span>Manage
                    Leave</span>
            </a>
        </li>
        <li>
            <a href="user-profile.php">
                <span class="item-main"><span style="font-size:20px;margin-right:5px;">&#128100;</span>User Profiles</span>
            </a>
        </li>
        <li>
            <a href="profile.php">
                <span class="item-main"><span style="font-size:20px;margin-right:5px;">&#128100;</span>Profile</span>
            </a>
        </li>
        <li>
            <a href="logout.php">
                <span class="item main"><span style="font-size:20px;margin-right:5px;">&#x21E4;</span>Logout</span>
            </a>
        </li>
    </ul>
</div>