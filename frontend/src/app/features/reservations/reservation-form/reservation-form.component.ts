import { Component, EventEmitter, Inject, Input, OnInit, Output } from '@angular/core';
import { FormBuilder, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { ReservationService } from '../reservation.service';
import { Reservation } from '../reservation.model';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatNativeDateModule } from '@angular/material/core';
import { MAT_DIALOG_DATA, MatDialog } from '@angular/material/dialog';
import { MatSnackBar, MatSnackBarModule } from '@angular/material/snack-bar';
import { MatButton } from '@angular/material/button';
import { CommonModule,formatDate, DatePipe } from '@angular/common';

@Component({
  selector: 'app-reservation-form',
  standalone: true,
  imports: [
    MatFormFieldModule,
    MatButton,
    CommonModule,
    MatInputModule,
    MatDatepickerModule,
    MatNativeDateModule,
    ReactiveFormsModule,
    FormsModule,
    MatSnackBarModule],
  templateUrl: './reservation-form.component.html',
  styleUrls: ['./reservation-form.component.css'],
  providers: [DatePipe]
})
export class ReservationFormComponent implements OnInit {
  @Input() reservation?: Reservation;
  @Output() reservationUpdated = new EventEmitter<void>();

  reservationData: Reservation = { event_space_id: 0, event_name: '', start_time: '', end_time: '', status: '' };
  reservationForm: FormGroup;

  constructor(private reservationService: ReservationService, private datePipe: DatePipe,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private snackBar: MatSnackBar,
    private formBuilder: FormBuilder

  ) {
    this.reservationForm = this.formBuilder.group({
      event_name: ['', Validators.required],
      start_time: ['', Validators.required],
      end_time: ['', Validators.required],
      event_space_id: [0],
      status: [''] 
    });
  }

  ngOnInit(): void {}


  formatDateTime(isoDate: string): string {
    const date = new Date(isoDate);
    const formattedDate = this.datePipe.transform(date, 'yyyy-MM-dd HH:mm:ss');
    return formattedDate ? formattedDate : '';
  }
  
  createOrUpdateReservation(): void {
    if (this.reservationForm.invalid) {
      this.snackBar.open('Por favor, completa todos los campos requeridos.', 'Cerrar', {
        duration: 3000,
      });
      return;
    }

    const reservationData: Reservation = this.reservationForm.value;

    if (this.reservation) {
       const reservationData: Reservation = {
      ...this.reservationForm.value,
      start_time: this.formatDateTime(this.reservationForm.get('start_time')?.value),
      end_time: this.formatDateTime(this.reservationForm.get('end_time')?.value),
      event_space_id: this.data?.event_space_id,
    };
      this.reservationService.updateReservation(this.reservation.event_space_id, reservationData).subscribe({
        next: () => {
          this.reservationUpdated.emit();
          this.snackBar.open('Reservación actualizada con éxito!', 'Cerrar', {
            duration: 3000,
          });
        },
        error: (error) => {
          console.error('Error al actualizar la reservación', error);
          this.snackBar.open(error.error.message || 'Error al actualizar la reservación', 'Cerrar', {
            duration: 3000,
          });
        }
      });
    } else {
      const reservationData: Reservation = {
        ...this.reservationForm.value,
        start_time: this.formatDateTime(this.reservationForm.get('start_time')?.value),
        end_time: this.formatDateTime(this.reservationForm.get('end_time')?.value),
        event_space_id: this.data?.event_space_id,
      };
      this.reservationService.createReservation(reservationData).subscribe({
        next: () => {
          this.reservationUpdated.emit();
          this.snackBar.open('Reservación creada con éxito!', 'Cerrar', {
            duration: 3000,
          });
        },
        error: (error) => {
          console.error('Error al crear la reservación', error);
          this.snackBar.open(error.error.message || 'Error al crear la reservación', 'Cerrar', {
            duration: 3000,
          });
        }
      });
    }

    this.resetForm();
  }

  resetForm(): void {
    this.reservationForm.reset();
  }
}
