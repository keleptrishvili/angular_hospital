// File: src/app/auth.service.ts
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root', // Ensures this service is provided globally
})
export class AuthService {
  register(userData: any) {
    throw new Error('Method not implemented.');
  }
  constructor(private http: HttpClient) {}

  // Example API call
  getUserData() {
    return this.http.get('http://127.0.0.1:8000/api/register');
  }
}
