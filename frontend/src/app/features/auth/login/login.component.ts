import { Component } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { AuthService } from '../auth.service';
import { Router } from '@angular/router';
import { MatSnackBar } from '@angular/material/snack-bar';
import { MatError, MatFormField, MatLabel } from '@angular/material/form-field';
import { MatIcon } from '@angular/material/icon';
import { MatCard, MatCardContent, MatCardHeader } from '@angular/material/card';
import { MatToolbar } from '@angular/material/toolbar';
import { MatButton } from '@angular/material/button';
import { CommonModule } from '@angular/common';
import { MatInput } from '@angular/material/input';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [
    ReactiveFormsModule, 
    MatInput,
    MatFormField,
    MatError,
    MatLabel, 
    MatFormField, 
    MatIcon, 
    MatCard, 
    MatToolbar, 
    MatCardHeader, 
    MatCardContent, 
    MatButton, 
    CommonModule],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent {
  loginForm: FormGroup;
  hidePassword = true;

  constructor(
    private fb: FormBuilder,
    private authService: AuthService,
    private router: Router,
    private snackBar: MatSnackBar
  ) {
    this.loginForm = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', Validators.required]
    });
  }

  login() {
    this.onSubmit();
  }

  onSubmit() {
    if (this.loginForm.valid) {
      this.authService.login(this.loginForm.value).subscribe(
        (response) => {
          console.log(response.data);
          this.authService.deleteToken();
          this.authService.storeToken(response.data.token);
          this.snackBar.open('Inició sesión exitosamente!', 'Cerrar', {
            duration: 2000,
          });

          this.router.navigate(['/event-spaces']);
        },
        (error) => {
          console.error('Error al iniciar sesión', error);
          this.snackBar.open('Error al iniciar sesión. Inténtalo de nuevo.', 'Cerrar', {
            duration: 2000,
          });
        }
      );
    } else {
      this.snackBar.open('Por favor, completa el formulario correctamente.', 'Cerrar', {
        duration: 2000,
      });
    }
  }
}
