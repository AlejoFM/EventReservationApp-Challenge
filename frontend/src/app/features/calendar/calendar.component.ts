import { Component, OnInit } from '@angular/core';
import { FormControl, ReactiveFormsModule } from '@angular/forms';
import { MatDatepicker, MatDatepickerModule } from '@angular/material/datepicker';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatSnackBar } from '@angular/material/snack-bar';
import { ReservationService } from '../reservations/reservation.service';
import { MatDatepickerInputEvent } from '@angular/material/datepicker';
import { CommonModule } from '@angular/common';
import { MatDialog } from '@angular/material/dialog';
import { ReservationFormComponent } from '../reservations/reservation-form/reservation-form.component';

@Component({
  selector: 'app-calendar',
  standalone: true,
  imports: [MatDatepickerModule, MatFormFieldModule, MatInputModule, ReactiveFormsModule, CommonModule, MatDatepicker],
  templateUrl: './calendar.component.html',
  styleUrls: ['./calendar.component.css'],
})
export class CalendarComponent {
  reservedDates = new Set<string>();
  dateControl = new FormControl();
  constructor(private dialog: MatDialog, private snackBar: MatSnackBar) {}

  onDateChange(event: MatDatepickerInputEvent<Date>) {
    const selectedDate = event.value ? this.formatDate(event.value) : null;
    if (selectedDate && this.reservedDates.has(selectedDate)) {
      this.snackBar.open('Esta fecha ya está reservada.', 'Cerrar', { duration: 2000 });
    } else {
      this.snackBar.open('Fecha disponible para reservar.', 'Cerrar', { duration: 2000 });
      this.openReservationForm(selectedDate!); 
    }
  }

  openReservationForm(selectedDate: string): void {
    const dialogRef = this.dialog.open(ReservationFormComponent, {
      data: { 
        start_time: selectedDate,
        end_time: null,
      }, 
      width: '400px', 
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log('El diálogo se cerró');
    });
  }

  formatDate(date: Date): string {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0'); 
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  }
}
