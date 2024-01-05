<?php

if (empty($_POST['filter'])) {
    exit('No filter selected');
}
session_start();
require '../../config/config.php';
$id = $_SESSION['id'];
$filter = $_POST['filter'];
$appointments = [];
switch ($filter) {
    case 'all':
        $appointments = get_all_appointments($id);
        //        print_r($appointments);
        display_appointments($appointments);
        break;
    case 'today':
        $appointments = get_todays_appointments($id);
        //        print_r($appointments);
        display_appointments($appointments);
        break;
    case 'tomorrow':
        $appointments = get_tomorrow_appointments($id);
        //        print_r($appointments);
        display_appointments($appointments);
        break;
    case 'unfinished':
        $appointments = get_unfinished_appointments($id);
        //        print_r($appointments);
        display_appointments($appointments);
        break;
    case 'finished':
        $appointments = get_finished_appointments($id);
        //        print_r($appointments);
        display_appointments($appointments);
        break;
    default:
        exit('Invalid filter');
}

function display_appointments($appointments)
{
    foreach ($appointments as $appointment) {
        $id = $appointment['appointment_id'];
        $fullName = $appointment['first_name'].' '.$appointment['last_name'];
        $report_title = $appointment['report_title'];
        $role = $appointment['user_role'];
        $initials = strtoupper(substr($appointment['first_name'], 0, 1)).strtoupper(substr($appointment['last_name'], 0, 1));
        $time_of_event = date('g:i A', strtotime($appointment['time_of_event']));
        $date_of_event = DateTime::createFromFormat('Y-m-d', $appointment['date_of_event'])->format('F j, Y');
        $appointment_time = date('g:i A', strtotime($appointment['appointment_time']));
        $appointment_date = DateTime::createFromFormat('Y-m-d', $appointment['appointment_date'])->format('F j, Y');
        $status = $appointment['status'];
        $unfinished = "
            						<div class='flex items-center gap-2 py-1 bg-warning-100 rounded-full w-max px-2'>
							<svg width='8' height='8' viewBox='0 0 8 8' fill='none' xmlns='http://www.w3.org/2000/svg'>
								<circle cx='4' cy='4' r='3' fill='#F79009'/>
							</svg>
							<p>Unfinished</p>
						</div>
            ";
        $finished = "
            						<div class='flex items-center gap-2 py-1 bg-success-100 rounded-full w-max px-2'>
							<svg width='8' height='8' viewBox='0 0 8 8' fill='none' xmlns='http://www.w3.org/2000/svg'>
								<circle cx='4' cy='4' r='3' fill='#12B76A'/>
							</svg>
							<p>Finished</p>
						</div>
            ";
        echo "
            <tr>
					<td>
						<div class='flex items-center gap-2'>
							<div class='w-10 aspect-square rounded-full bg-brand-200 text-lg flex items-center justify-center text-brand-600 font-semibold'>$initials</div>
							<div class='w-max'>
								<p class='font-medium'>$fullName</p>
								<p class='text-gray-500 capitalize'>$role</p>
							</div>

						</div>
					</td>
					<td>
						<div class='w-max'>
							<p class='font-medium'>$report_title</p>
							<p class='text-gray-500'>$date_of_event | $time_of_event</p>
						</div>
					</td>
					<td>
						<div class=''>
							<p class='font-medium'>$appointment_date</p>
							<p class='text-gray-500'>$appointment_time</p>
						</div>
					</td>
					<td>";
        echo $status === 'finished' ? $finished : $unfinished;
        echo "</td>
					<td>
						<div class=''>
							<button type='button' onclick='deleteAppointment($id)' class='delete flex items-center gap-2 bg-error-600 hover:bg-error-700 px-4 py-2 rounded-lg text-white font-medium' value='$id'>
								<svg width='20' height='20' viewBox='0 0 20 20' fill='none' xmlns='http://www.w3.org/2000/svg'>
									<path d='M2.5 4.99996H4.16667M4.16667 4.99996H17.5M4.16667 4.99996V16.6666C4.16667 17.1087 4.34226 17.5326 4.65482 17.8451C4.96738 18.1577 5.39131 18.3333 5.83333 18.3333H14.1667C14.6087 18.3333 15.0326 18.1577 15.3452 17.8451C15.6577 17.5326 15.8333 17.1087 15.8333 16.6666V4.99996H4.16667ZM6.66667 4.99996V3.33329C6.66667 2.89127 6.84226 2.46734 7.15482 2.15478C7.46738 1.84222 7.89131 1.66663 8.33333 1.66663H11.6667C12.1087 1.66663 12.5326 1.84222 12.8452 2.15478C13.1577 2.46734 13.3333 2.89127 13.3333 3.33329V4.99996' stroke='white' stroke-width='1.67' stroke-linecap='round' stroke-linejoin='round'/>
								</svg>
                                Cancel
							</button>
						</div>
					</td>
				</tr>
            ";
    }
}
