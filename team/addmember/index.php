<form id="form" action="send.php" method="POST">
            <div class="form-group">
                <label for="text">Staff Name:</label>
                <input type="text" class="form-control" id="adminName" name="adminName" placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label for="InputEmail1">Email:</label>
                <input type="email" class="form-control" id="InputEmail1" name="InputEmail1" placeholder="Enter email">
            </div>
            <div class="form-group">
				<select name="rank" id="rank">
					<option value='1'>Helpdesk</option>
					<option value='2'>Moderator</option>
					<option value='3'>Admin</option>
					<option value='4'>Server Admin</option>
					<option value='5'>Manager</option>
				</select>
            </div>
            <input type="submit" value="Submit" id="bt_submit" />
</form>