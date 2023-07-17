/**
 * @license
 * Copyright 2019 Google LLC. All Rights Reserved.
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * =============================================================================
 */
import { LeakyRelu, util } from '@tensorflow/tfjs-core';
import { CppDType } from './types';
let wasmFunc;
function setupFunc(backend) {
    wasmFunc = backend.wasm.cwrap(LeakyRelu, null /* void */, [
        'number',
        'number',
        'number',
        'number', // out_id
    ]);
}
export function leakyRelu(args) {
    const { inputs: { x }, attrs: { alpha }, backend } = args;
    const xId = backend.dataIdMap.get(x.dataId).id;
    // According to TF API, LeakyRelu returns float32 when input is either float32
    // or int32.
    const out = backend.makeOutput(x.shape, 'float32');
    if (util.sizeFromShape(x.shape) !== 0) {
        const outId = backend.dataIdMap.get(out.dataId).id;
        wasmFunc(xId, CppDType[x.dtype], alpha, outId);
    }
    return out;
}
export const leakyReluConfig = {
    kernelName: LeakyRelu,
    backendName: 'wasm',
    setupFunc,
    kernelFunc: leakyRelu,
};
//# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiTGVha3lSZWx1LmpzIiwic291cmNlUm9vdCI6IiIsInNvdXJjZXMiOlsiLi4vLi4vLi4vLi4vLi4vLi4vdGZqcy1iYWNrZW5kLXdhc20vc3JjL2tlcm5lbHMvTGVha3lSZWx1LnRzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBOzs7Ozs7Ozs7Ozs7Ozs7R0FlRztBQUVILE9BQU8sRUFBMkIsU0FBUyxFQUErQyxJQUFJLEVBQUMsTUFBTSx1QkFBdUIsQ0FBQztBQUk3SCxPQUFPLEVBQUMsUUFBUSxFQUFDLE1BQU0sU0FBUyxDQUFDO0FBRWpDLElBQUksUUFDMEUsQ0FBQztBQUUvRSxTQUFTLFNBQVMsQ0FBQyxPQUFvQjtJQUNyQyxRQUFRLEdBQUcsT0FBTyxDQUFDLElBQUksQ0FBQyxLQUFLLENBQUMsU0FBUyxFQUFFLElBQUksQ0FBQyxVQUFVLEVBQUU7UUFDeEQsUUFBUTtRQUNSLFFBQVE7UUFDUixRQUFRO1FBQ1IsUUFBUSxFQUFHLFNBQVM7S0FDckIsQ0FBQyxDQUFDO0FBQ0wsQ0FBQztBQUVELE1BQU0sVUFBVSxTQUFTLENBQ3JCLElBQzBFO0lBRTVFLE1BQU0sRUFBQyxNQUFNLEVBQUUsRUFBQyxDQUFDLEVBQUMsRUFBRSxLQUFLLEVBQUUsRUFBQyxLQUFLLEVBQUMsRUFBRSxPQUFPLEVBQUMsR0FBRyxJQUFJLENBQUM7SUFFcEQsTUFBTSxHQUFHLEdBQUcsT0FBTyxDQUFDLFNBQVMsQ0FBQyxHQUFHLENBQUMsQ0FBQyxDQUFDLE1BQU0sQ0FBQyxDQUFDLEVBQUUsQ0FBQztJQUMvQyw4RUFBOEU7SUFDOUUsWUFBWTtJQUNaLE1BQU0sR0FBRyxHQUFHLE9BQU8sQ0FBQyxVQUFVLENBQUMsQ0FBQyxDQUFDLEtBQUssRUFBRSxTQUFTLENBQUMsQ0FBQztJQUVuRCxJQUFJLElBQUksQ0FBQyxhQUFhLENBQUMsQ0FBQyxDQUFDLEtBQUssQ0FBQyxLQUFLLENBQUMsRUFBRTtRQUNyQyxNQUFNLEtBQUssR0FBRyxPQUFPLENBQUMsU0FBUyxDQUFDLEdBQUcsQ0FBQyxHQUFHLENBQUMsTUFBTSxDQUFDLENBQUMsRUFBRSxDQUFDO1FBQ25ELFFBQVEsQ0FBQyxHQUFHLEVBQUUsUUFBUSxDQUFDLENBQUMsQ0FBQyxLQUFLLENBQUMsRUFBRSxLQUFLLEVBQUUsS0FBSyxDQUFDLENBQUM7S0FDaEQ7SUFFRCxPQUFPLEdBQUcsQ0FBQztBQUNiLENBQUM7QUFFRCxNQUFNLENBQUMsTUFBTSxlQUFlLEdBQWlCO0lBQzNDLFVBQVUsRUFBRSxTQUFTO0lBQ3JCLFdBQVcsRUFBRSxNQUFNO0lBQ25CLFNBQVM7SUFDVCxVQUFVLEVBQUUsU0FBa0M7Q0FDL0MsQ0FBQyIsInNvdXJjZXNDb250ZW50IjpbIi8qKlxuICogQGxpY2Vuc2VcbiAqIENvcHlyaWdodCAyMDE5IEdvb2dsZSBMTEMuIEFsbCBSaWdodHMgUmVzZXJ2ZWQuXG4gKiBMaWNlbnNlZCB1bmRlciB0aGUgQXBhY2hlIExpY2Vuc2UsIFZlcnNpb24gMi4wICh0aGUgXCJMaWNlbnNlXCIpO1xuICogeW91IG1heSBub3QgdXNlIHRoaXMgZmlsZSBleGNlcHQgaW4gY29tcGxpYW5jZSB3aXRoIHRoZSBMaWNlbnNlLlxuICogWW91IG1heSBvYnRhaW4gYSBjb3B5IG9mIHRoZSBMaWNlbnNlIGF0XG4gKlxuICogaHR0cDovL3d3dy5hcGFjaGUub3JnL2xpY2Vuc2VzL0xJQ0VOU0UtMi4wXG4gKlxuICogVW5sZXNzIHJlcXVpcmVkIGJ5IGFwcGxpY2FibGUgbGF3IG9yIGFncmVlZCB0byBpbiB3cml0aW5nLCBzb2Z0d2FyZVxuICogZGlzdHJpYnV0ZWQgdW5kZXIgdGhlIExpY2Vuc2UgaXMgZGlzdHJpYnV0ZWQgb24gYW4gXCJBUyBJU1wiIEJBU0lTLFxuICogV0lUSE9VVCBXQVJSQU5USUVTIE9SIENPTkRJVElPTlMgT0YgQU5ZIEtJTkQsIGVpdGhlciBleHByZXNzIG9yIGltcGxpZWQuXG4gKiBTZWUgdGhlIExpY2Vuc2UgZm9yIHRoZSBzcGVjaWZpYyBsYW5ndWFnZSBnb3Zlcm5pbmcgcGVybWlzc2lvbnMgYW5kXG4gKiBsaW1pdGF0aW9ucyB1bmRlciB0aGUgTGljZW5zZS5cbiAqID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG4gKi9cblxuaW1wb3J0IHtLZXJuZWxDb25maWcsIEtlcm5lbEZ1bmMsIExlYWt5UmVsdSwgTGVha3lSZWx1QXR0cnMsIExlYWt5UmVsdUlucHV0cywgVGVuc29ySW5mbywgdXRpbH0gZnJvbSAnQHRlbnNvcmZsb3cvdGZqcy1jb3JlJztcblxuaW1wb3J0IHtCYWNrZW5kV2FzbX0gZnJvbSAnLi4vYmFja2VuZF93YXNtJztcblxuaW1wb3J0IHtDcHBEVHlwZX0gZnJvbSAnLi90eXBlcyc7XG5cbmxldCB3YXNtRnVuYzogKFxuICAgIHhJZDogbnVtYmVyLCBkdHlwZTogbnVtYmVyLCBsZWFreXJlbHVBbHBoYTogbnVtYmVyLCBvdXRJZDogbnVtYmVyKSA9PiB2b2lkO1xuXG5mdW5jdGlvbiBzZXR1cEZ1bmMoYmFja2VuZDogQmFja2VuZFdhc20pOiB2b2lkIHtcbiAgd2FzbUZ1bmMgPSBiYWNrZW5kLndhc20uY3dyYXAoTGVha3lSZWx1LCBudWxsIC8qIHZvaWQgKi8sIFtcbiAgICAnbnVtYmVyJywgIC8vIHhfaWRcbiAgICAnbnVtYmVyJywgIC8vIGR0eXBlXG4gICAgJ251bWJlcicsICAvLyBsZWFreXJlbHVfYWxwaGFcbiAgICAnbnVtYmVyJywgIC8vIG91dF9pZFxuICBdKTtcbn1cblxuZXhwb3J0IGZ1bmN0aW9uIGxlYWt5UmVsdShcbiAgICBhcmdzOlxuICAgICAgICB7aW5wdXRzOiBMZWFreVJlbHVJbnB1dHMsIGF0dHJzOiBMZWFreVJlbHVBdHRycywgYmFja2VuZDogQmFja2VuZFdhc219KTpcbiAgICBUZW5zb3JJbmZvIHtcbiAgY29uc3Qge2lucHV0czoge3h9LCBhdHRyczoge2FscGhhfSwgYmFja2VuZH0gPSBhcmdzO1xuXG4gIGNvbnN0IHhJZCA9IGJhY2tlbmQuZGF0YUlkTWFwLmdldCh4LmRhdGFJZCkuaWQ7XG4gIC8vIEFjY29yZGluZyB0byBURiBBUEksIExlYWt5UmVsdSByZXR1cm5zIGZsb2F0MzIgd2hlbiBpbnB1dCBpcyBlaXRoZXIgZmxvYXQzMlxuICAvLyBvciBpbnQzMi5cbiAgY29uc3Qgb3V0ID0gYmFja2VuZC5tYWtlT3V0cHV0KHguc2hhcGUsICdmbG9hdDMyJyk7XG5cbiAgaWYgKHV0aWwuc2l6ZUZyb21TaGFwZSh4LnNoYXBlKSAhPT0gMCkge1xuICAgIGNvbnN0IG91dElkID0gYmFja2VuZC5kYXRhSWRNYXAuZ2V0KG91dC5kYXRhSWQpLmlkO1xuICAgIHdhc21GdW5jKHhJZCwgQ3BwRFR5cGVbeC5kdHlwZV0sIGFscGhhLCBvdXRJZCk7XG4gIH1cblxuICByZXR1cm4gb3V0O1xufVxuXG5leHBvcnQgY29uc3QgbGVha3lSZWx1Q29uZmlnOiBLZXJuZWxDb25maWcgPSB7XG4gIGtlcm5lbE5hbWU6IExlYWt5UmVsdSxcbiAgYmFja2VuZE5hbWU6ICd3YXNtJyxcbiAgc2V0dXBGdW5jLFxuICBrZXJuZWxGdW5jOiBsZWFreVJlbHUgYXMgdW5rbm93biBhcyBLZXJuZWxGdW5jLFxufTtcbiJdfQ==