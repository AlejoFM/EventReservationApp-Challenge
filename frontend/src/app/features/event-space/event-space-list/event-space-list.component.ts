import { Component, OnInit } from '@angular/core';
import { CommonModule, NgFor, NgForOf } from '@angular/common';
import { EventSpaceService } from '../event-space.service';

import { Router } from '@angular/router';
import { MatCard, MatCardContent, MatCardHeader } from '@angular/material/card';
import { MatToolbar } from '@angular/material/toolbar';
import { MatPaginator, PageEvent } from '@angular/material/paginator';
import { MatSnackBar } from '@angular/material/snack-bar';
import { MatCell, MatHeaderCell, MatHeaderRow, MatRow, MatTable, MatTableModule } from '@angular/material/table';
import { AuthService } from '../../auth/auth.service';
import { MatDialog, MatDialogConfig } from '@angular/material/dialog';
import { EventSpaceFormComponent } from '../event-space-form/event-space-form.component';
import { min } from 'rxjs';
import { MatButton, MatButtonModule } from '@angular/material/button';
import { NgxSkeletonLoaderModule } from 'ngx-skeleton-loader';
import { CalendarComponent } from '../../calendar/calendar.component';
import { FormBuilder, FormGroup, FormsModule, NgModel, Validators } from '@angular/forms';
import { MatFormField, MatLabel } from '@angular/material/form-field';
import { ReservationFormComponent } from '../../reservations/reservation-form/reservation-form.component';
import { ReservationService } from '../../reservations/reservation.service';
import { MatOption, MatSelect } from '@angular/material/select';
import { MatInput } from '@angular/material/input';

@Component({
  selector: 'app-event-space-list',
  standalone: true,
  imports: [NgxSkeletonLoaderModule, FormsModule, NgForOf, MatLabel,MatSelect, MatInput, MatOption, MatLabel, MatFormField,
    MatTable, MatHeaderCell, MatCell, MatHeaderRow, MatRow, MatTableModule, MatButton, MatButtonModule,
    MatCard, MatCardHeader, MatToolbar, MatCard, MatCardHeader, MatPaginator, MatCardContent],
  templateUrl: './event-space-list.component.html',
  styleUrl: './event-space-list.component.css'
})
export class EventSpaceListComponent implements OnInit {
  types: string[] = ['Salón', 'Auditorio', 'Sala de Reuniones'];
  selectedType: string | null = null; // 
  selectedCapacity: number | null = null; 
  startDate: string = ''; 
  endDate: string = '';
  eventSpaces: any[] = [];
  displayedColumns: string[] = ['name', 'type', 'actions', 'capacity'];
  totalEventSpaces: number = 0;
  pageSize: number = 10;
  pageIndex: number = 0;
  isAdmin: boolean = false;
  isLoading: boolean = true;
  reservationForm: FormGroup;


  constructor(
    private eventSpaceService: EventSpaceService,
    private snackBar: MatSnackBar,
    private router: Router,
    private authService: AuthService,
    private dialog: MatDialog,
    private fb: FormBuilder,
    private reservationService: ReservationService
  ) {
    this.reservationForm = this.fb.group({
      event_name: ['', Validators.required],
      start_time: ['', Validators.required],
      end_time: ['', Validators.required],
      status: [''],
      space_id: ['', Validators.required] 
    });
  
  }

  ngOnInit() {
    this.isAdmin =this.authService.isAdmin()
    this.loadEventSpaces();
  }

  loadEventSpaces(filters: { type?: string; capacity?: number; startDate?: string; endDate?: string } = {}): void {
    
    this.eventSpaceService.getEventSpaces(this.pageIndex, this.pageSize, filters).subscribe(
      (data) => {
        this.eventSpaces = data.paginated_data.event_spaces; 
        this.totalEventSpaces = data.paginated_data.total; 
        this.isLoading = false; 
      },
      (error) => {
        console.error('Error al cargar espacios de eventos', error);
        this.snackBar.open('Error al cargar espacios de eventos.', 'Cerrar', {
          duration: 2000,
        });
        this.isLoading = false; 
      }
    );
  }

  addEventSpace() {
    this.router.navigate(['/add-event-space']); 
  }

  editEventSpace(eventSpace: any) {
    this.router.navigate(['/edit-event-space', eventSpace.id]);
  }

  deleteEventSpace(eventSpace: any) {
    if (confirm(`¿Estás seguro de que deseas eliminar el espacio: ${eventSpace.name}?`)) {
      this.eventSpaceService.deleteEventSpace(eventSpace.id).subscribe(
        () => {
          this.snackBar.open('Espacio de evento eliminado exitosamente.', 'Cerrar', {
            duration: 2000,
          });
          this.loadEventSpaces(); 
        },
        (error) => {
          console.error('Error al eliminar el espacio de evento', error);
          this.snackBar.open('Error al eliminar el espacio de evento.', 'Cerrar', {
            duration: 2000,
          });
        }
      );
    }
  }
  getEventSpaceById(id: number) {
    this.router.navigate(['/event-spaces', id]);
  }
  onPageChange(event: PageEvent) {
    this.pageIndex = event.pageIndex; 
    this.pageSize = event.pageSize; 
    this.loadEventSpaces(); 
  }

  openCreateEventSpaceModal(): void {
    const dialogRef = this.dialog.open(EventSpaceFormComponent, {
      width: '400px',  
      data: { eventSpace: null }, 
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        console.log('El modal ha sido cerrado y se ha guardado un espacio');
      }
    });
  }

  openEditEventSpaceModal(eventSpace: any): void {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.data = { eventSpace };
    const dialogRef = this.dialog.open(EventSpaceFormComponent, dialogConfig);


    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        console.log('El modal ha sido cerrado y el espacio ha sido actualizado');
      }
    });
  }
  applyFilters(): void {
    const filters = {
      type: this.selectedType !== null ? this.selectedType : undefined, 
      capacity: this.selectedCapacity !== null ? this.selectedCapacity : undefined,
      startDate: this.startDate || undefined, 
      endDate: this.endDate || undefined, 
    };
    this.loadEventSpaces(filters); 
  }
  openReservationForm(eventSpace: any): void {
    const dialogConfig = new MatDialogConfig();
    
    dialogConfig.data = {
      event_space_id: eventSpace.id,
      space_name: eventSpace.name,
      // Puedes agregar más datos si es necesario
    };
  
    const dialogRef = this.dialog.open(ReservationFormComponent, dialogConfig);
  
    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        console.log('El formulario de reserva fue enviado:', result);
      }
    });
  }
}