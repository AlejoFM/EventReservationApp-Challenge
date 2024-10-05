import { Injectable } from '@angular/core';
import { CanActivate, Router } from '@angular/router';
import { AuthService } from '../auth.service';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AdminGuard implements CanActivate {

  constructor(private authService: AuthService, private router: Router) {}

  canActivate(): boolean | Observable<boolean> {
    const isAdmin = this.authService.isAdmin(); 
    if (!isAdmin) {
      this.router.navigate(['/']); 
      return false;
    }
    return true;
  }
}
