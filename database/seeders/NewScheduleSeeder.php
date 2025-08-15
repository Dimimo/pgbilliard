<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class NewScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = $this->scheduleArray();
        foreach ($schedules as $schedule) {
            Schedule::factory()->create($schedule);
        }
    }

    private function scheduleArray(): array
    {
        return array(
            array('id' => '1', 'format_id' => '1', 'position' => '1', 'player' => '1', 'home' => '1', 'created_at' => '2024-12-24 06:03:19', 'updated_at' => '2024-12-24 06:03:19'),
            array('id' => '2', 'format_id' => '1', 'position' => '2', 'player' => '2', 'home' => '1', 'created_at' => '2024-12-24 06:03:24', 'updated_at' => '2024-12-24 06:03:24'),
            array('id' => '3', 'format_id' => '1', 'position' => '3', 'player' => '3', 'home' => '1', 'created_at' => '2024-12-24 06:03:33', 'updated_at' => '2024-12-24 06:03:33'),
            array('id' => '4', 'format_id' => '1', 'position' => '4', 'player' => '4', 'home' => '1', 'created_at' => '2024-12-24 06:03:37', 'updated_at' => '2024-12-24 06:03:37'),
            array('id' => '5', 'format_id' => '1', 'position' => '1', 'player' => '1', 'home' => '0', 'created_at' => '2024-12-24 06:14:17', 'updated_at' => '2024-12-24 06:14:17'),
            array('id' => '6', 'format_id' => '1', 'position' => '2', 'player' => '2', 'home' => '0', 'created_at' => '2024-12-24 06:14:30', 'updated_at' => '2024-12-24 06:14:30'),
            array('id' => '7', 'format_id' => '1', 'position' => '3', 'player' => '3', 'home' => '0', 'created_at' => '2024-12-24 06:14:33', 'updated_at' => '2024-12-24 06:14:33'),
            array('id' => '8', 'format_id' => '1', 'position' => '4', 'player' => '4', 'home' => '0', 'created_at' => '2024-12-24 06:14:35', 'updated_at' => '2024-12-24 06:14:35'),
            array('id' => '10', 'format_id' => '1', 'position' => '5', 'player' => '1', 'home' => '0', 'created_at' => '2024-12-24 06:14:46', 'updated_at' => '2024-12-24 06:14:46'),
            array('id' => '11', 'format_id' => '1', 'position' => '5', 'player' => '1', 'home' => '1', 'created_at' => '2024-12-24 06:14:59', 'updated_at' => '2024-12-24 06:14:59'),
            array('id' => '12', 'format_id' => '1', 'position' => '5', 'player' => '2', 'home' => '1', 'created_at' => '2024-12-24 06:15:02', 'updated_at' => '2024-12-24 06:15:02'),
            array('id' => '13', 'format_id' => '1', 'position' => '5', 'player' => '2', 'home' => '0', 'created_at' => '2024-12-24 06:15:09', 'updated_at' => '2024-12-24 06:15:09'),
            array('id' => '14', 'format_id' => '1', 'position' => '6', 'player' => '3', 'home' => '1', 'created_at' => '2024-12-24 06:15:27', 'updated_at' => '2024-12-24 06:15:27'),
            array('id' => '16', 'format_id' => '1', 'position' => '8', 'player' => '1', 'home' => '1', 'created_at' => '2024-12-24 06:15:31', 'updated_at' => '2024-12-24 06:15:31'),
            array('id' => '17', 'format_id' => '1', 'position' => '9', 'player' => '2', 'home' => '1', 'created_at' => '2024-12-24 06:15:33', 'updated_at' => '2024-12-24 06:15:33'),
            array('id' => '18', 'format_id' => '1', 'position' => '6', 'player' => '2', 'home' => '0', 'created_at' => '2024-12-24 06:15:42', 'updated_at' => '2024-12-24 06:15:42'),
            array('id' => '19', 'format_id' => '1', 'position' => '7', 'player' => '1', 'home' => '0', 'created_at' => '2024-12-24 06:15:44', 'updated_at' => '2024-12-24 06:15:44'),
            array('id' => '21', 'format_id' => '1', 'position' => '9', 'player' => '3', 'home' => '0', 'created_at' => '2024-12-24 06:15:48', 'updated_at' => '2024-12-24 06:15:48'),
            array('id' => '26', 'format_id' => '1', 'position' => '11', 'player' => '1', 'home' => '1', 'created_at' => '2024-12-24 06:16:18', 'updated_at' => '2024-12-24 06:16:18'),
            array('id' => '27', 'format_id' => '1', 'position' => '12', 'player' => '4', 'home' => '1', 'created_at' => '2024-12-24 06:16:21', 'updated_at' => '2024-12-24 06:16:21'),
            array('id' => '28', 'format_id' => '1', 'position' => '13', 'player' => '3', 'home' => '1', 'created_at' => '2024-12-24 06:16:23', 'updated_at' => '2024-12-24 06:16:23'),
            array('id' => '29', 'format_id' => '1', 'position' => '14', 'player' => '2', 'home' => '1', 'created_at' => '2024-12-24 06:16:26', 'updated_at' => '2024-12-24 06:16:26'),
            array('id' => '30', 'format_id' => '1', 'position' => '11', 'player' => '2', 'home' => '0', 'created_at' => '2024-12-24 06:16:33', 'updated_at' => '2024-12-24 06:16:33'),
            array('id' => '31', 'format_id' => '1', 'position' => '12', 'player' => '3', 'home' => '0', 'created_at' => '2024-12-24 06:16:35', 'updated_at' => '2024-12-24 06:16:35'),
            array('id' => '32', 'format_id' => '1', 'position' => '13', 'player' => '1', 'home' => '0', 'created_at' => '2024-12-24 06:16:37', 'updated_at' => '2024-12-24 06:16:37')
        );
    }
}
