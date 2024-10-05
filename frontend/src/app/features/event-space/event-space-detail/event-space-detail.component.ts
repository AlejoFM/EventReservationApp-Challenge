import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { EventSpaceService } from '../event-space.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { AuthService } from '../../auth/auth.service';
import { MatCard, MatCardActions, MatCardContent, MatCardHeader, MatCardSubtitle, MatCardTitle } from '@angular/material/card';
import { MatButton } from '@angular/material/button';
import { NgxSkeletonLoaderModule } from 'ngx-skeleton-loader';

@Component({
  selector: 'app-event-space-detail',
  standalone: true,
  imports: [MatCard,MatButton,NgxSkeletonLoaderModule, MatCardContent, MatCardHeader, MatCardHeader, MatCardActions, MatCardTitle, MatCardSubtitle],
  templateUrl: './event-space-detail.component.html',
  styleUrl: './event-space-detail.component.css'
})
export class EventSpaceDetailsComponent implements OnInit {
  eventSpace: any;
  isAdmin: boolean = false;
  isLoading = true;
  constructor(
    private route: ActivatedRoute,
    private eventSpaceService: EventSpaceService,
    private snackBar: MatSnackBar,
    private router: Router,
    private authService: AuthService
  ) {}

  ngOnInit() {
    this.isAdmin = this.authService.isAdmin();
    this.loadEventSpaceDetails();
  }

  loadEventSpaceDetails() {
    const eventSpaceId = parseInt(this.route.snapshot.paramMap.get('id')!);

    if (!eventSpaceId) {

      this.snackBar.open('Error al cargar detalles del espacio de evento.', 'Cerrar', {
        duration: 2000,
      });
      this.router.navigate(['']);
    }

    if (eventSpaceId) {
      this.eventSpaceService.getEventSpaceById(eventSpaceId).subscribe(
        (data) => {
          this.eventSpace = data.data;
          this.isLoading = false;
        },
        (error) => {
          if (error.status === 401) {
            this.snackBar.open('Error al cargar los detalles del espacio de evento.', 'Cerrar', {
              duration: 2000,
            });
            this.router.navigate(['']);
          }
          console.error('Error al cargar los detalles del espacio de evento', error);
          this.snackBar.open('Error al cargar detalles del espacio de evento.', 'Cerrar', {
            duration: 2000,
          });
        }
      );
    }
  }

  editEventSpace() {
    this.router.navigate(['/edit-event-space', this.eventSpace.id]);
  }

  deleteEventSpace() {
    if (confirm(`¿Estás seguro de que deseas eliminar el espacio: ${this.eventSpace.name}?`)) {
      this.eventSpaceService.deleteEventSpace(this.eventSpace.id).subscribe(
        () => {
          this.snackBar.open('Espacio de evento eliminado exitosamente.', 'Cerrar', {
            duration: 2000,
          });
          this.router.navigate(['/event-spaces']);
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

  goBack() {
    this.router.navigate(['/event-spaces']);
  }
}