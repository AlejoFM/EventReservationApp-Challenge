import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Router } from '@angular/router';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
    private apiUrl = 'http://localhost:80/api'; 

    constructor(private http: HttpClient, private snackBar: MatSnackBar, private router: Router) {}

    isLoggedIn(): boolean {
      const token = localStorage.getItem('jwt_token');

      return !!token && !this.isTokenExpired(token);

    }
  
    login(credentials: { email: string; password: string }): Observable<any> {
      return this.http.post(`${this.apiUrl}/login`, credentials);
    }
  
    storeToken(token: string): void {
      localStorage.setItem('jwt_token', token);
    }

    deleteToken(): void {
      localStorage.removeItem('jwt_token');
    }
  
    logout(): void {
      localStorage.removeItem('jwt_token');
    }
  
    isAdmin(): boolean {
      const token = localStorage.getItem('jwt_token');
      const payload = this.decodeJWT(token!);
      const isAdmin = payload.role === 'admin';
      return isAdmin;
    }
    isTokenExpired(token: string): boolean {
      try {
        const payload = this.decodeJWT(token);
        const exp = payload.exp;
        return Date.now() >= exp * 1000;
      } catch (error) {
        this.snackBar.open('Token expirado. Redirigiendo al login...', 'Cerrar', {
          duration: 2000,
        });
        this.router.navigate(['/login']);
        return true;
      }
    }
  
    private decodeJWT(token: string): any {
      const payload = token.split('.')[1]; 
      const decoded = JSON.parse(atob(payload)); 
      return decoded; 
    }
}
