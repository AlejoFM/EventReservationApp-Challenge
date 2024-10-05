import { ApplicationConfig, importProvidersFrom, provideZoneChangeDetection } from '@angular/core';
import { provideRouter } from '@angular/router';

import { routes } from './app.routes';
import { provideAnimationsAsync } from '@angular/platform-browser/animations/async';
import { HTTP_INTERCEPTORS, HttpClient, HttpClientModule } from '@angular/common/http';
import { AuthInterceptor } from './features/auth/auth.interceptor';
import { NgxSkeletonLoaderModule } from 'ngx-skeleton-loader';
import { MatNativeDateModule, provideNativeDateAdapter } from '@angular/material/core';

export const appConfig: ApplicationConfig = {
  providers: [
    importProvidersFrom(HttpClient, HttpClientModule,NgxSkeletonLoaderModule ),
     provideZoneChangeDetection({ eventCoalescing: true }),
    provideNativeDateAdapter(),
      provideRouter(routes),
       provideAnimationsAsync(),
    {
      provide: HTTP_INTERCEPTORS,
      useClass: AuthInterceptor,
      multi: true 
    }
  ]
};
