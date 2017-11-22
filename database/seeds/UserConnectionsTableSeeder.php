<?php

use App\UserConnection;
use Illuminate\Database\Seeder;

class UserConnectionsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Declare variables
		$numUsers = 100;

		// Assign random connection count between 0-50 for each user
		$connectionCounts = [];
		for ($i=0; $i < $numUsers; $i++) {
			array_push($connectionCounts, rand(0, 50));
		}

		// Get additional connections needed for user
		function additionalConnectionCount($userId, $connectionCounts){
			// Get all connections for user
			$currentConnections = DB::table('user_connections')
				->where('user_id', $userId)
				->get();
			$currentCount = count($currentConnections);
			return $connectionCounts[$userId - 1] - $currentCount;
		}

		// Find if connection is valid between two user ids
		function isConnectedIdValid($currentUserId, $connectedId, $connectionCounts){
			// Not valid if ids are the same
			if ($currentUserId == $connectedId){
				return false;
			}

			// Find if current user is already connected to connected user id
			$connectedRows = DB::table('user_connections')
				->where('user_id', $currentUserId)
				->where('connected_user_id', $connectedId)
				->get();
			$connectedCount = count($connectedRows);
			
			// Not valid if users are already connected or the connected user id already has full connections
			if ($connectedCount >= 1 || additionalConnectionCount($connectedId, $connectionCounts) <= 0) {
				return false;
			} else {
				return true;
			}
		}

		// Generate user_connections records
		for ($i=1; $i <= $numUsers; $i++){
			// Add remaining connections needed for each user
			for ($j=0; $j < additionalConnectionCount($i, $connectionCounts); $j++){
				// Generate random connected user id until the connection is valid between each user
				$connectedId = rand(1, $numUsers);
				while (!isConnectedIdValid($i, $connectedId, $connectionCounts)){
					$connectedId = rand(1, $numUsers);
				}

        // Insert connection records
        $userConnection = new UserConnection;
        $userConnection->user_id = $i;
        $userConnection->connected_user_id = $connectedId;
        $userConnection->save();

        $inverseConnection = new UserConnection;
        $inverseConnection->user_id = $connectedId;
        $inverseConnection->connected_user_id = $i;
        $inverseConnection->save();
			}
		}
	}
}
