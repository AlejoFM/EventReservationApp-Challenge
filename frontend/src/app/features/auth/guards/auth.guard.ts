import { Injectable } from '@angular/core';
import { CanActivate, Router } from '@angular/router';
import { AuthService } from '../auth.service'; 
import { Observable } from 'rxjs';
import { MatSnackBar } from '@angular/material/snack-bar';

@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {

  constructor(private authService: AuthService, private router: Router, private snackBar: MatSnackBar) {}

  canActivate(): boolean | Observable<boolean> {
    const isAuthenticated = this.authService.isLoggedIn(); 
    if (!isAuthenticated) {
      this.snackBar.open('Sesión no encontrada. Redirigiendo al login...', 'Cerrar', {
        duration: 2000,
      });
      
      this.router.navigate(['/login']);
      return false;
    }
    const token = localStorage.getItem('jwt_token');
    const tokenExpired = this.authService.isTokenExpired(token!);
    if (tokenExpired) {
      this.snackBar.open('Token expirado. Redirigiendo al login...', 'Cerrar', {
        duration: 2000,
      });
      this.router.navigate(['/login']);
      return false;
    }
    return true;
  }
}
