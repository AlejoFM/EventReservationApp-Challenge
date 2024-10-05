import { Component, OnInit } from '@angular/core';
import { ReservationService } from '../reservation.service';
import { Reservation } from '../reservation.model';
import { MatTableDataSource, MatTableModule } from '@angular/material/table';
import { MatDialog } from '@angular/material/dialog'; 
import { NgxSkeletonLoaderModule } from 'ngx-skeleton-loader';
import { ReservationFormComponent } from '../reservation-form/reservation-form.component'; 
import { DatePipe, UpperCasePipe } from '@angular/common';
import { MatButtonModule } from '@angular/material/button';
import { ConfirmDialogComponent } from '../../../shared/components/dialogs/confirm-dialog.component/confirm-dialog.component.component';
import { CalendarComponent } from '../../calendar/calendar.component';

@Component({
  selector: 'app-reservation-list',
  standalone: true,
  templateUrl: './reservation-list.component.html',
  styleUrls: ['./reservation-list.component.css'],
  imports: [MatTableModule,CalendarComponent, MatButtonModule,UpperCasePipe, DatePipe, NgxSkeletonLoaderModule, ReservationFormComponent]
})
export class ReservationListComponent implements OnInit {
  displayedColumns: string[] = ['name', 'reservation_date', 'duration', 'actions', 'status'];
  isLoading: boolean = true;
  dataSource = new MatTableDataSource<any>();

  constructor(
    private reservationService: ReservationService,
    private dialog: MatDialog
  ) {}

  ngOnInit(): void {
    this.loadReservations();
  }

  loadReservations(): void {
    this.reservationService.getReservations().subscribe(data => {
      const reservations: Reservation[] = data.data;
      this.isLoading = false;
      reservations.forEach((reservation: Reservation) => {
        reservation.duration = (new Date(reservation.end_time).getTime() - new Date(reservation.start_time).getTime()) / 3600000;
      });

      this.dataSource = new MatTableDataSource(reservations);
    });
  }

  deleteReservation(id: number): void {
    const dialogRef = this.dialog.open(ConfirmDialogComponent); 

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        this.reservationService.deleteReservation(id).subscribe(() => {
          this.loadReservations(); 
        });
      }
    });
  }

  onEdit(reservation: Reservation): void {
    const dialogRef = this.dialog.open(ReservationFormComponent, {
      data: reservation,
      width: '600px' 
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        this.loadReservations(); 
      }
    });
  }
}
