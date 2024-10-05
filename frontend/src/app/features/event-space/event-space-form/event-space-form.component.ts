import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { EventSpaceService } from '../event-space.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { MAT_DIALOG_DATA, MatDialogActions, MatDialogContent, MatDialogRef } from '@angular/material/dialog';
import { MatError, MatFormField, MatLabel } from '@angular/material/form-field';
import { CommonModule, NgFor } from '@angular/common';
import { MatInput } from '@angular/material/input';
import { MatButtonModule } from '@angular/material/button';
import { MatOption } from '@angular/material/core';
import { MatSelect } from '@angular/material/select';
import { Router } from '@angular/router';

@Component({
  selector: 'app-event-space-form',
  standalone: true,
  imports: [MatFormField,MatButtonModule, MatOption, NgFor, MatSelect, MatOption, CommonModule,
     MatDialogContent, MatError, MatDialogContent, MatDialogActions, MatLabel, ReactiveFormsModule, MatInput],
  templateUrl: './event-space-form.component.html',
  styleUrl: './event-space-form.component.css'
})
export class EventSpaceFormComponent implements OnInit {
  eventSpaceTypes: string[] = ["Salón", "Auditorio", "Sala de Reuniones"];
  eventSpaceForm: FormGroup;
  isEditMode: boolean = false;

  constructor(
    private fb: FormBuilder,
    private eventSpaceService: EventSpaceService,
    private snackBar: MatSnackBar,
    private dialogRef: MatDialogRef<EventSpaceFormComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private router: Router
  ) {
    this.isEditMode = !!data.eventSpace;
    this.eventSpaceForm = this.fb.group({
      name: [data.eventSpace ? data.eventSpace.name : '', [Validators.required]],
      type: [data.eventSpace ? data.eventSpace.type : '', [Validators.required]],
      capacity: [data.eventSpace ? data.eventSpace.capacity : '', [Validators.required]],
      location: [data.eventSpace ? data.eventSpace.location : '', [Validators.required]],
    });
  }

  ngOnInit(): void {
    this.eventSpaceForm.get('type')?.setValue(["Salón", "Auditorio", "Sala de Reuniones"]);
  }

  saveEventSpace() {
    if (this.eventSpaceForm.invalid) {
      return;
    }

    const eventSpaceData = this.eventSpaceForm.value;

    if (this.isEditMode) {
      console.log(this.eventSpaceForm.value);
      console.log(this.data.eventSpace);
      this.eventSpaceService.updateEventSpace(this.data.eventSpace, this.eventSpaceForm.value).subscribe( 
        () => {
          this.snackBar.open('Espacio de evento actualizado correctamente.', 'Cerrar', {
            duration: 2000,
          });
          this.dialogRef.close(true);
        },
        (error) => {
          console.error('Error al actualizar el espacio de evento', error);
          this.snackBar.open( error.error.message || 'Error al actualizar el espacio de evento.', 'Cerrar', {
            duration: 2000,
          });
          if (error.status === 401) {
            this.snackBar.open('Error al actualizar el espacio de evento. Token expirado. Redirigiendo al login...', 'Cerrar', {
              duration: 2000,
            });
            this.router.navigate(['/login']);
          }
        }
      );
    } else {
      this.eventSpaceService.addEventSpace(eventSpaceData).subscribe(
        () => {
          this.snackBar.open('Espacio de evento creado correctamente.', 'Cerrar', {
            duration: 2000,
          });
          this.dialogRef.close(true); 
        },
        (error) => {
          console.error('Error al crear el espacio de evento', error);
          this.snackBar.open(error.error.message || 'Error al crear el espacio de evento.', 'Cerrar', {
            duration: 2000,
          });
          if (error.status === 401) {
            this.snackBar.open('Error al actualizar el espacio de evento. Token expirado. Redirigiendo al login...', 'Cerrar', {
              duration: 2000,
            });
            this.router.navigate(['/login']);
          }
        }
      );
    }
  }

  closeDialog() {
    this.dialogRef.close(false);
  }
}
